<?php

namespace App\DAO;
use Illuminate\Support\Facades\DB;

class ServiceTuteur
{
    // Renvoie la liste des sessions
    public function getListeSessions() {
        $lesSessions = DB::table('session')
            ->Select()
            ->get();
        return $lesSessions;
    }

    // Renvoie une session
    public function getUneSession($idSession) {
        $uneSession = DB::table('session')
            ->Select()
            ->where('ID_SESSION', $idSession)
            ->first();
        return $uneSession;
    }

    // Renvoie l'id d'un stage
    public function getIdSession($idStage) {
        $uneSession = DB::table('stage')
            ->Select()
            ->where('stage.ID_STAGE', $idStage)
            ->first();
        return $uneSession;
    }

    // Renvoie un stage avec les informations de l'élève
    public function getUnStage($idStage) {
        $unStage = DB::table('stage')
            ->Select()
            ->leftJoin('etudiant', 'etudiant.NUM_ETUDIANT', '=', 'stage.NUM_ETUDIANT')
            ->where('ID_STAGE', $idStage)
            ->first();
        return $unStage;
    }

    // Renvoie le maître d'apprendtissage d'un stage
    public function getUnMAP($idStage) {
        $unMAP = DB::table('stage')
            ->Select()
            ->leftJoin('maitre_stage', 'maitre_stage.ID_MAITRESTAGE', '=', 'stage.ID_MAITRESTAGE')
            ->where('ID_STAGE', $idStage)
            ->first();
        return $unMAP;
    }

    // Renvoie les stages d'une session
    public function getListeStages($idSession) {
        $lesStages = DB::table('stage')
            ->Select()
            ->leftJoin('etudiant', 'etudiant.NUM_ETUDIANT', '=', 'stage.NUM_ETUDIANT')
            ->leftJoin('tuteur', 'tuteur.ID_TUTEUR', '=', 'stage.ID_TUTEUR')
            ->leftJoin('maitre_stage', 'maitre_stage.ID_MAITRESTAGE', '=', 'stage.ID_MAITRESTAGE')
            ->leftJoin('entreprise', 'entreprise.ID_ENTREPRISE', '=', 'maitre_stage.ID_ENTREPRISE')
            ->where('ID_SESSION', $idSession)
            ->get();
        return $lesStages;
    }

    // Renvoie les élèves d'une session suivi par un même tuteur
    public function getListeElevesSession($idSession, $idTuteur) {
        $lesStages = DB::table('stage')
            ->Select()
            ->leftJoin('etudiant', 'etudiant.NUM_ETUDIANT', '=', 'stage.NUM_ETUDIANT')
            ->leftJoin('tuteur', 'tuteur.ID_TUTEUR', '=', 'stage.ID_TUTEUR')
            ->leftJoin('maitre_stage', 'maitre_stage.ID_MAITRESTAGE', '=', 'stage.ID_MAITRESTAGE')
            ->where('ID_SESSION', $idSession)
            ->where('stage.ID_TUTEUR', $idTuteur)
            ->get();
        return $lesStages;
    }

    // Renvoie les fichiers d'une sessions
    public function getFichiers($idSession) {
        $fichiers = DB::table('files')
            ->Select()
            ->where('files.ID_SESSION', $idSession)
            ->get();
        return $fichiers;
    }


    // Renvoie les informations d'un tuteur
    public function getUnTuteur($idTuteur) {
        $unTuteur = DB::table('tuteur')
            ->Select()
            ->where('ID_TUTEUR', $idTuteur)
            ->first();
        return $unTuteur;
    }

    // Récupère le mail du responsable des stages
    public function getMailRespStage() {
        $mailResp = DB::table('responsable')
            ->Select()
            ->first();
        return $mailResp;
    }
}
