<?php

namespace App\DAO;
use Illuminate\Support\Facades\DB;


class ServicePromo
{

    public function getListePromos() {
        $lesPromos = DB::table('promo')
            ->Select()
            ->get();
        return $lesPromos;
    }

    public function addOnePromo() {
        $promo_name = $_POST['name'];
        $req = "insert into promo(IDPROMO,NOM) 
		values(1,:promo_name)";
		DB::insert($req, ['promo_name'=>$promo_name]);
        return true;
    }

}

?>