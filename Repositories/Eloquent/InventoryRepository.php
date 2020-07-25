<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Auth;
use DB;
use Cache;

class InventoryRepository
{

    public function sisaStok()
    {
        $currentPage = request()->get('page',1);

        $v = Cache::remember('dc_barang' . $currentPage, 10, function() {
            $id_unit  = Auth::user()->id_unit;
            $date     = Carbon::now()->format('Y-m-d');
            $cari     = request()->q;
            $barang  = DB::table('dc_barang')
            ->selectRaw(
              "dc_barang.id,
              dc_barang.nama_lengkap,
              sisa_stok(dc_barang.id, $id_unit, $date) as stok
            ")
            ->join('dc_barang_unit','dc_barang_unit.id_barang','=','dc_barang.id')
            ->where('nama', 'like', "$cari%")
            ->where('aktif', 'Ya')
            ->where('id_unit', $id_unit)->orderBy('dc_barang.id','asc');

        });

        return response()->json($v);
    }


}
