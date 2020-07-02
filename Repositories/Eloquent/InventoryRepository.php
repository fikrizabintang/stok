<?php

namespace App\Repositories\Eloquent;
use App\Models\Inventory\Stok;

use Carbon\Carbon;
use Auth;

class InventoryRepository
{

    protected $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date->now()->format('Y-m-d');
    }

    public function sisaStok($id)
    {
        $get = Stok::select('masuk','keluar')->where('id_barang', $id)
        ->where('id_unit', Auth::user()->id_unit)
        ->where('ed', '>', Carbon::now())->limit(1000);
        $sum = ($get->sum('masuk') - $get->sum('keluar'));
        return $sum;
    }


}
