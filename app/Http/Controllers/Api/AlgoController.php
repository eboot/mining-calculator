<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Algo;
use Illuminate\Http\Request;

class AlgoController extends Controller
{

    public function index(Request $request)
    {

        return Algo::all();
    }

}
