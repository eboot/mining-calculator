<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Algo;
use Illuminate\Http\Request;

class CoinController extends Controller
{

    public function index(Request $request)
    {

        $data = $request->all();
        $coins = [];
        foreach ($data as $aname => $hr) {
            if ($hr >0) {
                $algo = Algo::where('name', $aname)->first();
                if ($algo) {
                    foreach ($algo->coins()->with(['algo', 'exchanges'])->get() as $coin) {
                        $coin->rewards = $coin->getReward($hr);
                        $coins[] = $coin;
                    }
                }
            }
        }

        return $coins;
    }

}
