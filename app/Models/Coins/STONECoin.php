<?php
namespace App\Models\Coins;

class  STONECoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://stonecrypto.org/api/getdifficulty');
        $hash = file_get_contents('http://stonecrypto.org/api/getnetworkhashps');

        return compact('diff','hash');
    }
}