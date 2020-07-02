<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Stok;
use App\Repositories\Eloquent\InventoryRepository;

class API_ObatController extends Controller
{
    protected $inventoryRepositories;

    public function __construct(InventoryRepository $inventoryRepositories)
    {
        $this->inventoryRepositories = $inventoryRepositories;
    }

    public function index(Request $request)
    {
          $cari = $request->q;
          $barang = Barang::where('nama', 'like', "$cari%")
          ->where('aktif','Ya')
          ->paginate(15);

          $barang_count = Barang::limit(15);

          $data = [
              'total'           => $barang_count->count(),
          ];

          foreach($barang as $key => $post) {
              $sisa_stok    = $this->inventoryRepositories->sisaStok($post->id);

              $data['data'][$key] = [
                  'id'              => $post->id,
                  'nama'            => $post->nama_lengkap,
                  'id_sediaan'      => $post->id_sediaan,
                  'stok'            => $sisa_stok,
              ];
          }
          return response()->json($data);
    }

}
