<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'dc_barang';

    public function pabrik(){
          return $this->belongsTo('App\Models\MasterData\Inventory\Pabrik','id_pabrik');
    }

    public function stok(){
          return $this->hasMany('App\Models\Inventory\Stok','id_barang');
    }

    public function sisa_stok(){
          return $this->hasMany('App\Models\Inventory\Stok','id_barang');
    }
}
