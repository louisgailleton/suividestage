<?php


namespace App\DAO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ServiceUser
{
    public function getResponsable($email, $pwd) {
        $user = DB::table('responsable')
            ->Select()
            ->where('MAIL_RESPONSABLE', $email)
            ->first();
        if(!empty($user) && Crypt::decryptString($user->MDP_RESPONSABLE) == $pwd){
            return $user;
        }
        
    }

    public function getTuteur($email, $pwd) {
        $user = DB::table('tuteur')
            ->Select()
            ->where('MAIL_TUTEUR', $email)
            ->first();
        if(!empty($user) && Crypt::decryptString($user->MDP_TUTEUR) == $pwd){
            return $user;
        }
    }
    public function getEleve($num, $pwd) {
        $user = DB::table('etudiant')
            ->Select()
            ->where('NUM_ETUDIANT', $num)
            ->first();
        if(!empty($user) && Crypt::decryptString($user->MDP_ETUDIANT) == $pwd){
            return $user;
        }
    }
    public function newPWD($user,$role,$old_mdp,$new_mdp) {
        $user_find = DB::table($role)
            ->Select('MDP_' .strtoupper($role))
            ->where(($role == 'etudiant' ? 'NUM_' : 'ID_') .strtoupper($role), $user)
            ->first();
        switch ($role) {
            case "etudiant":
                $mdp_name = "MDP_ETUDIANT";
                break;
            case "tuteur":
                $mdp_name = "MDP_TUTEUR";
                break;
            case "responsable":
                $mdp_name = "MDP_RESPONSABLE";
                break;
        }
        if(Crypt::decryptString($user_find->$mdp_name) == $old_mdp){
            $req = "update " .$role ." set MDP_" .strtoupper($role) ."
             = :mdp WHERE " .($role == 'etudiant' ? 'NUM_' : 'ID_') .strtoupper($role) ."= :user";
            DB::update($req, ['mdp'=> Crypt::encryptString($new_mdp),'user'=> $user]);
            $user_verify = DB::table($role)
            ->Select('MDP_' .strtoupper($role))
            ->where(($role == 'etudiant' ? 'NUM_' : 'ID_') .strtoupper($role), $user)
            ->first();
            
            
            if(Crypt::decryptString($user_verify->$mdp_name) == $new_mdp){
                return 3;
            }
            else{
                return 2;
            }
        }
        else{
            return 2;
        }
    }

}
