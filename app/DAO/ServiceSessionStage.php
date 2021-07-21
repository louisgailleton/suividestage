<?php


namespace App\DAO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;


class ServiceSessionStage
{
    public function getListeSessions() {
        $lesSessions = DB::table('session')
            ->Select()
            ->get();
        return $lesSessions;
    }

    public function getListeTuteurs() {
        $lesTuteurs = DB::table('tuteur')
            ->Select()
            ->get();
        return $lesTuteurs;
    }

    public function getListePromos() {
        $lesPromos = DB::table('promo')
            ->Select()
            ->get();
        return $lesPromos;
    }

    public function addOneSession() {
        $session_name = $_POST['name'];
        $nb_cr = $_POST['nb_cr'];
        $nb_rapport = $_POST['nb_rapport'];
        $req = "insert into session(NOM_SESSION,COMPTERENDU_SESSION,RAPPORT_SESSION)
		values(:session_name,:nb_cr,:nb_rapport)";
		DB::insert($req, ['session_name'=>$session_name,'nb_cr'=>$nb_cr,'nb_rapport'=>$nb_rapport]);
        return true;
    }



    public function addOneTuteur() {

        // Génération d'un mot de passe
        function GenPass($nbr_caractere = 8) // Reçoi le nbr de caractère que doit contenir le mdp (sinon 6 par défaut)
        {
            if(is_numeric($nbr_caractere))
            {
                // Liste des caractères disponible pour la génération du mdp (cases de 0 à 61)
                $caracteres = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);

                // Création de l'array qui contiendra le mdp
                $array_mdp = array();
                for($boucle = 1; $boucle <= $nbr_caractere; $boucle++)
                {
                    // Ajout du caractère aléatoire dans l'array du mdp
                    $array_mdp[] = $caracteres[mt_rand(0,count($caracteres)-1)];
                }

                $mdp = implode("",$array_mdp); // Transfo de l'array en string
                return $mdp; // Retourne la chaine contenant le mdp
            }
            else
            {
                return false; // la fonction n'a pas reçu un nombre en paramètre
            }
        }
        $tuteur_name = $_POST['name'];
        $tuteur_firstname = $_POST['fistname'];
        $email = $_POST['email'];
        $password = GenPass(8) ;
        $nbMax = $_POST['nbMax'];
        $req = "insert into tuteur(NOM_TUTEUR,PRENOM_TUTEUR,MAIL_TUTEUR,MDP_TUTEUR,NB_MAX)
		values(:name,:firstname,:email,:mdp,:nbmax)";
		DB::insert($req, ['name'=> $tuteur_name,'firstname'=> $tuteur_firstname,'email'=> $email,'mdp'=> Crypt::encryptString($password), 'nbmax' => $nbMax ]);
        //Envoie d'un mail à létudiant pour lui envoyer son mdp
        $to_email = $email;
        $data = array("tuteur" => "$tuteur_firstname $tuteur_name", "email" =>$email, "mdp" => $password);

        Mail::send('responsable.mailAddTuteur', $data, function($message) use ($to_email) {
            $message->to($to_email);
            $message->subject('Compte ajouté, voici vos informations personnelles');
        });
        return true;
    }

    public function getUneSessions($idSession) {
        $uneSession = DB::table('session')
            ->Select()
            ->where('ID_SESSION', $idSession)
            ->first();
        return $uneSession;
    }

    public function deleteSession($idSession) {
        DB::delete('delete from stage where ID_SESSION = ?',[$idSession]);
        DB::delete('delete from session where ID_SESSION = ?',[$idSession]);
        return true;
    }

    public function suppressionFichier($idFichier){
        DB::delete('delete from files where ID = ?',[$idFichier]);
    }

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

    public function addOneTuteurStage() {

        $stage_id = $_POST['id_stage'];
        $tuteur_id = $_POST['id_tuteur'];
        $req = "update stage set ID_TUTEUR
		 = :tuteur_id WHERE ID_STAGE = :stage_id";
		DB::update($req, ['stage_id'=> $stage_id,'tuteur_id'=> $tuteur_id]);
        return true;
    }

}
