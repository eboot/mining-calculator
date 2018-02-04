<?php
namespace App\Models\Coins;

class  GBXCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://explorer.gobyte.network:5001/api/getdifficulty');
        $hash = file_get_contents('http://explorer.gobyte.network:5001/api/getnetworkhashps');

        return compact('diff','hash');
    }
}