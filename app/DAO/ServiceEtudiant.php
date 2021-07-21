<?php


namespace App\DAO;
use Illuminate\Support\Facades\DB;


class ServiceEtudiant
{
    public function getSessions($numEtudiant) {
        $sessions = DB::table('stage')
            ->Select()
            ->join('session', 'session.ID_SESSION', '=', 'stage.ID_SESSION')
            ->where('NUM_ETUDIANT', $numEtudiant)
            ->get();
        return $sessions;
    }

    public function getSession($idSession) {
        $session = DB::table('session')
            ->Select()
            ->where('ID_SESSION', $idSession)
            ->first();
        return $session;
    }

    public function getStage($numEtudiant, $idSession) {
        $stage = DB::table('stage')
            ->Select()
            ->leftJoin('maitre_stage', 'maitre_stage.ID_MAITRESTAGE', '=', 'stage.ID_MAITRESTAGE')
            ->leftJoin('entreprise', 'entreprise.ID_ENTREPRISE', '=', 'maitre_stage.ID_ENTREPRISE')
            ->leftJoin('etudiant', 'etudiant.NUM_ETUDIANT', '=', 'stage.NUM_ETUDIANT')
            ->where('stage.NUM_ETUDIANT', $numEtudiant)
            ->where('ID_SESSION', $idSession)
            ->first();
        return $stage;
    }

    public function getSessionByIdStage($idStage) {
        $session = DB::table('stage')
            ->Select()
            ->leftJoin('session', 'session.ID_SESSION', '=', 'stage.ID_SESSION')
            ->where('ID_STAGE', $idStage)
            ->first();
        return $session;
    }

    public function udpateInfoStage($idStage, $nomEntreprise, $adresseEntreprise, $villeEntreprise, $cpEntreprise, $sujetStage, $nomMAP, $prenomMAP, $mailMAP, $telMAP) {
        DB::table('entreprise')
            ->insert([
                'NOM_ENTREPRISE' => $nomEntreprise,
                'ADRESSE_ENTREPRISE' => $adresseEntreprise,
                'VILLE_ENTREPRISE' => $villeEntreprise,
                'CP_ENTREPRISE' => $cpEntreprise,
            ]);

        $entreprise = DB::table('entreprise')
            ->Select()
            ->where('NOM_ENTREPRISE', $nomEntreprise)
            ->first();
        $idEntreprise = $entreprise->ID_ENTREPRISE;

        DB::table('maitre_stage')
            ->insert([
                'NOM_MAITRESTAGE' => $nomMAP,
                'PRENOM_MAITRESTAGE' => $prenomMAP,
                'MAIL_MAITRESTAGE' => $mailMAP,
                'TELEPHONE_MAITRESTAGE' => $telMAP,
                'ID_ENTREPRISE' => $idEntreprise
            ]);

        $map = DB::table('maitre_stage')
            ->Select()
            ->where('NOM_MAITRESTAGE', $nomMAP)
            ->first();
        $idMAP = $map->ID_MAITRESTAGE;

        DB::table('stage')
            ->where('ID_STAGE', $idStage)
            ->update([
                'ID_MAITRESTAGE' => $idMAP,
                'SUJET_STAGE' => $sujetStage
            ]);
    }



}
