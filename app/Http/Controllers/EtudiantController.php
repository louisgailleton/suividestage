<?php

namespace App\Http\Controllers;

use App\DAO\ServiceEtudiant;
use App\DAO\ServiceTuteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\File;

class EtudiantController extends Controller
{
    public function getSessions($numEtudiant){
        $serviceEtudiant = new ServiceEtudiant();
        $sessions = $serviceEtudiant->getSessions($numEtudiant);
        return view('etudiant.sessions', compact('sessions'));
    }

    public function getSession($idSession){
        $serviceEtudiant = new ServiceEtudiant();
        $session = $serviceEtudiant->getSession($idSession);
        $stage = $serviceEtudiant->getStage($_SESSION["num"], $idSession);
        if($stage->SUJET_STAGE == "") {
            return view('etudiant.form', compact('session'));
        } else {
            return redirect()->route('stage', ['numEtudiant' => $_SESSION["num"], 'idSession' => $idSession]);
        }
    }

    public function getStage($numEtudiant, $idSession){
        $serviceEtudiant = new ServiceEtudiant();
        $serviceTuteur = new ServiceTuteur();
        $session = $serviceEtudiant->getSession($idSession);
        $stage = $serviceEtudiant->getStage($numEtudiant, $idSession);
        $fichiers = $serviceTuteur->getFichiers($idSession);
        return view('etudiant.stage', compact('session', 'stage', 'fichiers'));
    }

    public function index()
    {
        return view('etudiant.stage');
    }

    public function envoieFichier(Request $req, $idStage)
    {
        $serviceEtudiant = new ServiceEtudiant();
        $session = $serviceEtudiant->getSessionByIdStage($idStage);

        for($i = 1; $i <= $session->COMPTERENDU_SESSION; $i ++) {
            $req->validate([
                'compteRendu' . $i => 'mimes:xls,pdf,doc,docx|max:5000'
            ]);
            $fileModel = new File;
            $compteRendu = "compteRendu$i";

            if($req->hasfile('compteRendu' . $i)) {
                $fileName = $_SESSION['num'] . '_compte_rendu' . $i . '_stage' . $idStage . '.' . $req->$compteRendu->getClientOriginalExtension();
                $filePath = $req->file('compteRendu' . $i)->storeAs('fichiers', $fileName, 'public');

                $fileModel->name = $fileName;
                $fileModel->file_path = $filePath;
                $fileModel->id_stage = $idStage;
                $fileModel->id_session = $session->ID_SESSION;
                $fileModel->compte_rendu = $i;
                $fileModel->save();

                return back()
                    ->with('success','Le fichier à été envoyé avec succès !');
            }
        }


        if($session->RAPPORT_SESSION == "1") {
            $req->validate([
                'rapportSession' => 'required|mimes:xls,pdf,doc,docx|max:5000'
            ]);
            $fileModel = new File;

            if($req->file()) {
                $fileName = $_SESSION['num'] . '_rapport_stage' . $idStage . '.' . $req->rapportSession->getClientOriginalExtension();
                $filePath = $req->file('rapportSession')->storeAs('fichiers', $fileName, 'public');

                $fileModel->name = $fileName;
                $fileModel->file_path = $filePath;
                $fileModel->id_stage = $idStage;
                $fileModel->rapport_stage = "1";
                $fileModel->id_session = $session->ID_SESSION;
                $fileModel->save();

                return back()
                    ->with('success','Le fichier à été envoyé avec succès !');
            }
        }
        return redirect()->route('stage', ['numEtudiant' => $_SESSION['num'], 'idSession' => $session->ID_SESSION]);

    }

    public function envoieMail(Request $request, $numEtudiant, $idSession){
        $serviceEtudiant = new ServiceEtudiant();
        $serviceTuteur = new ServiceTuteur();
        $stage = $serviceEtudiant->getStage($numEtudiant, $idSession);

        $idStage = $stage->ID_STAGE;

        $sujetStage = $request->sujet;

        $mailMAP = $request->email;
        $prenomMAP = $request->firstname;
        $telMAP = $request->tel;
        $nomMAP = $request->lastname;

        $nomEntreprise = $request->nom;
        $adresseEntreprise = $request->rue;
        $villeEntreprise = $request->ville;
        $cpEntreprise = $request->cp;

        $serviceEtudiant->udpateInfoStage($idStage, $nomEntreprise, $adresseEntreprise, $villeEntreprise, $cpEntreprise, $sujetStage, $nomMAP, $prenomMAP, $mailMAP, $telMAP);


        /*$respStage = $serviceTuteur->getMailRespStage();
        $to_email = $respStage->MAIL_RESPONSABLE;
        $data = array("etudiant" => "$prenom $nom", "entreprise" => "$entreprise", "adresse" => "$adresse", "sujet" => "$sujet", "maitreStage" => "$maitreStage", "mail" => "$mail", "tel" => "$tel");

        Mail::send('etudiant.mail', $data, function($message) use ($to_email) {
            $message->to($to_email);
            $message->subject('Informations à enregistrer');
        });*/

        return redirect()->route('stage', ['numEtudiant' => $numEtudiant, 'idSession' => $idSession]);
    }
}
