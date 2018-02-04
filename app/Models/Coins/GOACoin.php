<?php
namespace App\Models\Coins;

class  GOACoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('https://goacoin.be/api/getdifficulty');
        $hash = file_get_contents('https://goacoin.be/api/getnetworkhashps');

        return compact('diff','hash');
    }
}