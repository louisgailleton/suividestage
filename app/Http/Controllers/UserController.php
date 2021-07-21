<?php

namespace App\Http\Controllers;

use App\DAO\ServiceUser;
use App\Providers\RouteServiceProvider;


class UserController extends Controller
{

    public function getUser(){
        session_start();
        $serviceUser = new ServiceUser();
        $i = $_POST['type'];
        $identifiant = (!empty($_POST['email']) ? $_POST['email'] : $_POST['num']);
        $pwd = $_POST['password'];
        switch ($i) {
            case 1:
                $leUser = $serviceUser->getEleve($identifiant, $pwd);
                break;
            case 2:
                $leUser = $serviceUser->getTuteur($identifiant, $pwd);
                break;
            case 3:
                $leUser = $serviceUser->getResponsable($identifiant, $pwd);
                break;
        }
        if($leUser != null){
            switch ($i) {
                case 1:
                    $num = $leUser->NUM_ETUDIANT;
                    $name = $leUser->NOM_ETUDIANT;
                    $firstname = $leUser->PRENOM_ETUDIANT;
                    $role = 'etudiant';
                    break;
                case 2:
                    $id = $leUser->ID_TUTEUR;
                    $name = $leUser->NOM_TUTEUR;
                    $firstname = $leUser->PRENOM_TUTEUR;
                    $role = 'tuteur';
                    break;
                case 3:
                    $id = $leUser->ID_RESPONSABLE;
                    $name = $leUser->NOM_RESPONSABLE;
                    $firstname = $leUser->PRENOM_RESPONSABLE;
                    $role = 'responsable';
                    break;
            }
            if(isset($num)){
                $_SESSION['num'] = $num; 
            }
            if(isset($id)){
                $_SESSION['id'] = $id; 
            }
            $_SESSION['name'] = $firstname ." " .$name; 
            $_SESSION['role'] = $role; 
            return redirect()->route('account');

        }
        else{
            $error = 'Vos identifiants sont incorrects!';
            return redirect()->route('login')->with( ['error' => $error] );

        }
    }

    public function logout(){
        session_start();
        session_destroy();
        return redirect()->route('login');
    }

    public function updatePassword(){
        $user = isset($_SESSION['num']) ? $_SESSION['num'] : $_SESSION['id'];
        $role = $_SESSION['role'];
        $old_mdp = $_POST['old_mdp'];
        $new_mdp = $_POST['new_mdp'];
        $confirm_mdp = $_POST['confirm_mdp'];
        if($new_mdp != $confirm_mdp){
            return redirect()->route('account')->with( ['change' => 1] );
        }
        $majuscule = preg_match('@[A-Z]@', $new_mdp);
        $minuscule = preg_match('@[a-z]@', $new_mdp);
        $chiffre = preg_match('@[0-9]@', $new_mdp);
        if(!$majuscule || !$minuscule || !$chiffre || strlen($new_mdp) < 8){
            return redirect()->route('account')->with( ['change' => 4] );
        }
        $serviceUser = new ServiceUser();
        $change = $serviceUser->newPWD($user,$role,$old_mdp,$new_mdp);
        return redirect()->route('account')->with( ['change' => $change] );
    }

}