<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DAO\ServicePromo;

class PromoController extends Controller
{
    public function getListePromos(){
        $servicePromo = new ServicePromo();
        $lesPromos = $servicePromo->getListePromos();
        return view('addPromo', compact('lesPromos'));
    }

    public function addOnePromo(){
        $servicePromo = new ServicePromo();
        $lesPromos = $servicePromo->addOnePromo();
        return view('/home');
    }
}
