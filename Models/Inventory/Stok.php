<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'dc_stok';

    public function barang(){
          return $this->belongsTo('App\Models\Inventory\Barang','id_barang');
      }

    public function kemasan_barang(){
          return $this->belongsTo('App\Models\Inventory\KemasanBarang','id_barang','id_barang');
      }

    public function users(){
          return $this->belongsTo('App\User','id_users');
      }
}
