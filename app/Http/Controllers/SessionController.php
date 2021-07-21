<?php

namespace App\Http\Controllers;

use App\DAO\ServiceSessionStage;
use App\DAO\ServiceTuteur;
use Illuminate\Support\Facades\Storage;

class SessionController extends Controller
{
    public function getListeSessions(){
        $serviceStage = new ServiceSessionStage();
        $lesSessions = $serviceStage->getListeSessions();
        return view('/responsable/listeSessions', compact('lesSessions'));
    }

    public function getListeTuteurs(){
        $serviceStage = new ServiceSessionStage();
        $lesTuteurs = $serviceStage->getListeTuteurs();
        return view('/responsable/listeTuteurs', compact('lesTuteurs'));
    }

    public function getListeStages($id){
        $serviceTuteur = new ServiceSessionStage();
        $lesStages = $serviceTuteur->getListeStages($id);
        $uneSession = $serviceTuteur->getUneSessions($id);
        $lesTuteurs = $serviceTuteur->getListeTuteurs();
        return view('/responsable/listeStages', compact('lesStages','lesTuteurs', 'uneSession'));
    }

    public function deleteSession($id){
        $serviceResponsable = new ServiceSessionStage();
        $servicesTuteurs = new ServiceTuteur();
        $fichiersSession = $servicesTuteurs->getFichiers($id);
        foreach ($fichiersSession as $fichier){
            Storage::delete('public/'.$fichier->file_path);
            $serviceResponsable->suppressionFichier($fichier->id);
        }

        $laSession = $serviceResponsable->deleteSession($id);
        return redirect()->route('listeSessions');
    }

    public function setSession(){
        $serviceStage = new ServiceSessionStage();
        return view('/responsable/addSession');
    }

    public function addOneSession(){
        $serviceStage = new ServiceSessionStage();
        $lesPromos = $serviceStage->addOneSession();
        return redirect()->route('listeSessions');
    }

    public function uploadFile(){
        return view('/responsable/uploadFile');
    }

    public function setTuteur(){
        $serviceStage = new ServiceSessionStage();
        return view('/responsable/addTuteur');
    }

    public function addOneTuteur(){
        $serviceStage = new ServiceSessionStage();
        $lesPromos = $serviceStage->addOneTuteur();
        return redirect()->route('listeTuteurs');
    }

    public function addTuteurStage(){
        $serviceStage = new ServiceSessionStage();
        $leTuteur = $serviceStage->addOneTuteurStage();
        return redirect()->route('listeSessions');
    }
}
