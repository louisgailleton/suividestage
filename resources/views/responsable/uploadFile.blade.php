@extends('layouts.app')
@section('content')
<script>
    function AddStep(nombre){
        if(nombre < 100){
            var old_nb = jQuery(".box .num h2 #old_nb").text();
            console.log(old_nb);
            var new_nb = Math.round(parseInt(old_nb) + parseInt(nombre));
            jQuery(".box .percent .num h2 #old_nb").text(new_nb);
        }
        else{
            var new_nb = nombre;
            jQuery(".box .percent .num h2 #old_nb").text(new_nb);
        }
        if(new_nb === 100){
            jQuery(".box .text").text('Terminé!');
            jQuery(".box .text").append("</br><a onClick='window.history.back();' class='btn btn-success mt-3 d-flex justify-content-center align-items-center'>Retour</a>");
        }
    }
</script>
<?php
if (!empty($_FILES['file']['name'])) {
?>
<div class="container">
    <h1 id="titreSessions">Importation de données</h1>
    
</div>
<div class="box-body">
    <div class="box">
        <div class="percent">
            <svg>
                <circle cx="70" cy="70" r="70"></circle>
                <circle cx="70" cy="70" r="70"></circle>
            </svg>
            <div class="num">
                <h2><span id='old_nb'>0</span><span>%</span></h2>
            </div>
        </div>
        <h2 class="text">Progression...</h2>
    </div>
</div>
<?php
    //UPLOAD DU FICHIER CSV, vérification et insertion en BASE
    if (isset($_FILES["file"]["type"]) != "application/vnd.ms-excel") {
        die("Ce n'est pas un fichier de type .csv");
    } 
    elseif (is_uploaded_file($_FILES['file']['tmp_name'])) {
        $req_stage = "insert into stage(ID_SESSION,NUM_ETUDIANT) 
		values(:ID_SESSION,:NUM_ETUDIANT)";
        $req_add_etudiant = "insert into etudiant(NUM_ETUDIANT,NOM_ETUDIANT,PRENOM_ETUDIANT,TELEPHONE_ETUDIANT,MAIL_ETUDIANT,MDP_ETUDIANT) 
		values(:NUM_ETUDIANT,:NOM_ETUDIANT,:PRENOM_ETUDIANT,:TELEPHONE_ETUDIANT,:MAIL_ETUDIANT,:MDP_ETUDIANT)";
        $file = new SplFileObject($_FILES['file']['tmp_name']);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $i = 0;
        $step_for_loading_circle = 0;
        foreach ($file as $row) {
            $step_for_loading_circle++;
        }
        $step_for_loading_circle = 100 / $step_for_loading_circle;
        foreach ($file as $row) {
            
            if($i >1 && !empty($row)){
                $column = explode(";", $row[0]);
                $find_student = DB::table('etudiant')
                ->Select()
                ->where('NUM_ETUDIANT', $column[0])
                ->first();


                $find_in_stage = DB::table('stage')
                ->Select()
                ->where('NUM_ETUDIANT', $column[0])
                ->where('ID_SESSION', $_POST['idsession'])
                ->first();

                

                if(!empty($find_student)){
                    if($find_in_stage == null){
                        $args= ['ID_SESSION' => $_POST['idsession'], 'NUM_ETUDIANT' => $column[0]];
                        DB::insert($req_stage, $args);
                    }
                }
                else{
                    // Liste des caractères disponible pour la génération du mdp (cases de 0 à 61)
                    $caracteres = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
                    
                    // Création de l'array qui contiendra le mdp
                    $array_mdp = array();
                    for($boucle = 1; $boucle <= 8; $boucle++)
                    {	
                        // Ajout du caractère aléatoire dans l'array du mdp
                        $array_mdp[] = $caracteres[mt_rand(0,count($caracteres)-1)];
                    }
                    
                    $mdp = implode("",$array_mdp); // Transfo de l'array en string
                    $mdpfinal = Crypt::encryptString($mdp);
                    //Création du compte de l'étudiant
                    $args= ['NUM_ETUDIANT' => $column[0],'NOM_ETUDIANT' => $column[1],'PRENOM_ETUDIANT' => $column[2],'TELEPHONE_ETUDIANT' => $column[3],'MAIL_ETUDIANT' => $column[4],'MDP_ETUDIANT' => $mdpfinal ];
                    DB::insert($req_add_etudiant, $args);
                    
                    //Envoie d'un mail à létudiant pour lui envoyer son mdp
                    $to_email = $column[4];
                    $data = array("etudiant" => "$column[2] $column[1]", "identifiant" =>$column[0], "mdp" => $mdp);

                    Mail::send('responsable.mail', $data, function($message) use ($to_email) {
                        $message->to($to_email);
                        $message->subject('Compte ajouté, voici vos informations personnelles');
                    });

                    //Ajout de l'etudiant dans la session
                    $args= ['ID_SESSION' => $_POST['idsession'], 'NUM_ETUDIANT' => $column[0]];
                    DB::insert($req_stage, $args);
                }
            }
            else{
                $i++;
            }
            echo '<script>AddStep(' .$step_for_loading_circle .');</script>';
            
        }
        echo '<script>AddStep(100);</script>';
        
    } 
}elseif(empty($_FILES['file']['name'])){
?>
<div class="container mt-5">
    <h1 id="titreSessions">Vous n'avez pas séléctionez de fichier .csv</h1>
    <h3 id="titreSessions">Retournez sur la page précedente pour en choisir un.</h3>
    
</div>

<?php
}
?>

@stop