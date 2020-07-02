<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Stok;

use Carbon\Carbon;

class API_BarangController extends Controller
{

    public function index(Request $request)
    {
        // if(request()->ajax()){
          $cari = $request->q;
          $now = Carbon::now();

          $supplier = Barang::
          where('aktif', 'Ya')
          ->where('nama', 'like', "$cari%")
          ->orderBy('id', 'asc');

          if ($request->ekatalog)
             $supplier = $supplier->where('ekatalog', $request->ekatalog);
          if (isset($request->golongan) && $request->golongan <> 1)
             $supplier = $supplier->where('id_golongan', $request->golongan);
          if ($request->kategori)
             $supplier = $supplier->where('id_kategori', $request->kategori);

          $supplier = $supplier->paginate(5);

          $supplier_count = Barang::limit(5);

          $data = [
              'total'           => $supplier_count->count(),
          ];

          foreach($supplier as $key => $post) {
              $harga_satuan_supplier = ($post->hpp) - ($post->hpp * $post->diskon/100 );
              $sisa_stok    = Stok::selectRaw('IFNULL(SUM(masuk) - SUM(keluar), 0) AS stok')
              ->where('id_barang', $post->id)
              ->where('id_unit', 40)
              ->where('ed', '>', $now)->first();

              $data['data'][$key] = [
                  'id'                => $post->id,
                  'nama_lengkap'      => $post->nama_lengkap,
                  'harga_satuan'      => $harga_satuan_supplier,
                  'stok'              => $sisa_stok,
              ];
          }
          return response()->json($data);
        // }
        //   return view('error.index');
    }

}
