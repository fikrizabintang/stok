<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'dc_barang';

    public function stok(){
        return $this->hasMany('App\Models\Inventory\Stok','id_barang')->selectRaw('id_barang, sum(masuk)')->where('id_unit', Auth::user()->id_unit)->groupBy('id_barang');
    }
}
