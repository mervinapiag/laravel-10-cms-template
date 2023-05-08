<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Catalog;

class CatalogService {

    public function store($catalog) : Catalog
    {
        return DB::transaction(function () use($catalog){
            return Catalog::create($catalog);
        });
    }

    public function update($catalog, $request) : Catalog
    {
        return DB::transaction(function () use($catalog, $request){
            $catalog->title = $request['title'];
            $catalog->description = $request['description'];
            $catalog->div_color = $request['div_color'];
            $catalog->photo = $request['photo'];
            $catalog->update();
            return $catalog;
        });
    }

    public function destroy($catalog) : void
    {
        DB::transaction(function () use($catalog){
            $catalog->delete();
            return $catalog;
        });
    }

}
