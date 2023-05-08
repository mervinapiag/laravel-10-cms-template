<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Promo;

class PromoService {

    public function store($promo) : Promo
    {
        return DB::transaction(function () use($promo){
            return Promo::create($promo);
        });
    }

    public function update($promo, $request) : Promo
    {
        return DB::transaction(function () use($promo, $request){
            $promo->name = $request['name'];
            $promo->discount = $request['discount'];
            $promo->description = $request['description'];
            $promo->photo = $request['photo'];
            $promo->update();
            return $promo;
        });
    }

    public function destroy($promo) : void
    {
        DB::transaction(function () use($promo){
            $promo->delete();
            return $promo;
        });
    }

}
