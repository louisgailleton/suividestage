<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class Authentification
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        session_start();
        if(isset($_SESSION['name'])){
            if($_SESSION['role'] == "responsable"){
                if( Route::currentRouteName() == "listeSessions" ||
                    Route::currentRouteName() == "addSession" ||
                    Route::currentRouteName() == "addOneSession" ||
                    Route::currentRouteName() == "listeStages" ||
                    Route::currentRouteName() == "listeTuteurs" ||
                    Route::currentRouteName() == "addTuteur" ||
                    Route::currentRouteName() == "addOneTuteur" ||
                    Route::currentRouteName() == "addTuteurStage" ||
                    Route::currentRouteName() == "uploadFile" ||
                    Route::currentRouteName() == "deleteSession" ){
                    return $next($request);
                }
                elseif(Route::currentRouteName() == "account"){
                    return $next($request);
                }
                else{
                    return redirect()->route('account');
                }

            }
            elseif($_SESSION['role'] == "tuteur"){
                if( Route::currentRouteName() == "listeSessionsTuteur" ||
                    Route::currentRouteName() == "listeStagesTuteur" ||
                    Route::currentRouteName() == "getListeElevesSession" ||
                    Route::currentRouteName() == "envoiMail" ){
                    return $next($request);
                }
                elseif(Route::currentRouteName() == "account"){
                    return $next($request);
                }
                else{
                    return redirect()->route('account');
                }
            }
            elseif($_SESSION['role'] == "etudiant"){
                if( Route::currentRouteName() == "sessions" ||
                    Route::currentRouteName() == "infos" ||
                    Route::currentRouteName() == "stage" ||
                    Route::currentRouteName() == "envoieMailEtudiant"||
                    Route::currentRouteName() == "envoieFichier" ){
                    return $next($request);
                }
                elseif(Route::currentRouteName() == "account"){
                    return $next($request);
                }
                else{
                    return redirect()->route('account');
                }
            }
        }
        else{
            return redirect(RouteServiceProvider::LOGIN);
        }
    }
}
