<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::fallback(function () {
    /** This will check for the 404 view page unders /resources/views/errors/404 route */
    return view('404');
});

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('login', function(){
    return view('auth/login');
})->name('login');

Route::get('account', function(){
    return view('/account');
})->name('account')->middleware('auth');

Route::post('verifyUser', [App\Http\Controllers\UserController::class, 'getUser'])->name('verifyUser');

Route::get('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('home', function(){
    return view('home');
})->name('home')->middleware('auth');

//--------------------------------------------------Nouveau mot de passe----------------------------------------

Route::post('/changePassword', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('changePassword')->middleware('auth');


//--------------------------------------------------RESPONSABLE----------------------------------------
// Renvoie la liste des sessions
Route::get('/listeSessions', [App\Http\Controllers\SessionController::class, 'getListeSessions'])->name('listeSessions')->middleware('auth');
Route::post('/uploadFile', [App\Http\Controllers\SessionController::class, 'uploadFile'])->name('uploadFile')->middleware('auth');
// Ajout d'une session

Route::get('/addSession', [App\Http\Controllers\SessionController::class, 'setSession'])->name('addSession')->middleware('auth');

Route::post('/addOneSession', [App\Http\Controllers\SessionController::class, 'addOneSession'])->name('addOneSession')->middleware('auth');

// Renvoie la liste des stages responsable
Route::get('/listeStages/{idSession}', [App\Http\Controllers\SessionController::class, 'getListeStages'])->name('listeStages')->middleware('auth');

// Supprime la session selectionnée
Route::get('/deleteSession/{idSession}', [App\Http\Controllers\SessionController::class, 'deleteSession'])->name('deleteSession')->middleware('auth');

// Renvoie la liste des tuteurs responsables
Route::get('/listeTuteurs', [App\Http\Controllers\SessionController::class, 'getListeTuteurs'])->name('listeTuteurs')->middleware('auth');

//Ajout d'un tuteur

Route::get('/addTuteur', [App\Http\Controllers\SessionController::class, 'setTuteur'])->name('addTuteur')->middleware('auth');
Route::post('/addOneTuteur', [App\Http\Controllers\SessionController::class, 'addOneTuteur'])->name('addOneTuteur')->middleware('auth');

//Ajout d'un tuteur à un stage

Route::post('/addTuteurStage/', [App\Http\Controllers\SessionController::class, 'addTuteurStage'])->name('addTuteurStage')->middleware('auth');

//--------------------------------------------------TUTEUR----------------------------------------
// Renvoie la liste des sessions
Route::get('/listeSessionsTuteur', [App\Http\Controllers\TuteurController::class, 'getListeSessions'])->name('listeSessionsTuteur')->middleware('auth');;

// Renvoie la liste des stages
Route::get('/listeStagesTuteur/{idSession}', [App\Http\Controllers\TuteurController::class, 'getListeStages'])->name('listeStagesTuteur')->middleware('auth');

// Renvoie la liste des élèves d'une sessions
Route::get('/listeEleveSessionsTuteur/{idSession}/{idTuteur}', [App\Http\Controllers\TuteurController::class, 'getListeElevesSession'])->name('getListeElevesSession')->middleware('auth');

// Envoie un mail au responsable des stages
Route::get('/envoiMailResponsable/{idStage}/{idTuteur}', [App\Http\Controllers\TuteurController::class, 'envoiMail'])->name('envoiMail')->middleware('auth');

//--------------------------------------------------ETUDIANT----------------------------------------

// Renvoie la liste des sessions de l'étudiant
Route::get('sessions/{numEtudiant}', [App\Http\Controllers\EtudiantController::class, 'getSessions'])->name('sessions')->middleware('auth');

// Renvoie la session choisie par l'étudiant
Route::get('infos/{idSession}', [App\Http\Controllers\EtudiantController::class, 'getSession'])->name('infos')->middleware('auth');

// Envoie un mail au responsable des stages avec les informations rentrées par l'étudiant
Route::post('/envoieMail/{numEtudiant}/{idSession}', [App\Http\Controllers\EtudiantController::class, 'envoieMail'])->name('envoieMailEtudiant')->middleware('auth');

// Renvoie les infos du stage de la session choisie par l'étudiant
Route::get('stage/{numEtudiant}/{idSession}', [App\Http\Controllers\EtudiantController::class, 'getStage'])->name('stage')->middleware('auth');

Route::post('/envoieFichier/{idStage}', [App\Http\Controllers\EtudiantController::class, 'envoieFichier'])->name('envoieFichier')->middleware('auth');;
