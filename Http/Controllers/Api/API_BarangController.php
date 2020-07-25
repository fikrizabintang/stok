<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\InventoryRepository;

class ObatController extends Controller
{
    protected $inventoryRepositories;

    public function __construct(InventoryRepository $inventoryRepositories)
    {
        $this->inventoryRepositories = $inventoryRepositories;
    }

    public function index(Request $request)
    {
        return $this->inventoryRepositories->sisaStok();
    }

}
