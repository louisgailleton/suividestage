<?php

namespace App\Http\Controllers;

use App\DAO\ServiceTuteur;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class TuteurController extends Controller
{
    // Affiche la liste de toutes les sessions
    public function getListeSessions(){
        $serviceTuteur = new ServiceTuteur();
        $lesSessions = $serviceTuteur->getListeSessions();
        return view('tuteur.listeSessions', compact('lesSessions'));
    }

    // Affiche tous les stages d'une session
    public function getListeStages($idSession){
        $serviceTuteur = new ServiceTuteur();
        $lesStages = $serviceTuteur->getListeStages($idSession);
        $uneSession = $serviceTuteur->getUneSession($idSession);
        return view('tuteur.listeStages', compact('lesStages', 'uneSession'));
    }

    // Affiche tous les élèves suivis par un tuteur d'une session
    public function getListeElevesSession($idSession, $idTuteur){
        $serviceTuteur = new ServiceTuteur();
        $lesStages = $serviceTuteur->getListeElevesSession($idSession, $idTuteur);
        $uneSession = $serviceTuteur->getUneSession($idSession);
        $fichiers = $serviceTuteur->getFichiers($idSession);
        return view('tuteur.listeElevesSession', compact('lesStages', 'uneSession', 'fichiers'));
    }

    public function envoiMail($idStage, $idTuteur){
        $serviceTuteur = new ServiceTuteur();
        $unStage = $serviceTuteur->getUnStage($idStage);
        $unMAP = $serviceTuteur->getUnMAP($idStage);

        $unTuteur = $serviceTuteur->getUnTuteur($idTuteur);
        $prenomTuteur = $unTuteur->PRENOM_TUTEUR;
        $nomTuteur = $unTuteur->NOM_TUTEUR;

        $nomEleve = $unStage->NOM_ETUDIANT;
        $prenomEleve = $unStage->PRENOM_ETUDIANT;

        if($unStage->SUJET_STAGE == "" && $unStage->ID_MAITRESTAGE == "") {
            $sujetStage = "L'élève n'a pas encore de stage et de maître de stage";
        } else {
            $sujetStage = "Le sujet du stage de l'élève est \"$unStage->SUJET_STAGE\" et son MAP est $unMAP->PRENOM_MAITRESTAGE $unMAP->NOM_MAITRESTAGE";
        }

        $respStage = $serviceTuteur->getMailRespStage();
        $to_email = $respStage->MAIL_RESPONSABLE;
        $subject = "Le tuteur $prenomTuteur $nomTuteur souhaite suivre l'élève $prenomEleve $nomEleve";
        $data = array("nomEleve" => "$prenomEleve $nomEleve", "nomTuteur" => "$prenomTuteur $nomTuteur", "sujetStage" => $sujetStage);
        Mail::send('tuteur.mail', $data, function($message) use ($to_email, $subject) {
            $message->to($to_email)
                    ->subject($subject);
        });

        $session = $serviceTuteur->getIdSession($idStage);
        $idSession = $session->ID_SESSION;
        return redirect()->route('listeStagesTuteur', ['idSession' => $idSession]);
    }
}
