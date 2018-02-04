<?php
namespace App\Models\Coins;

class  CRCCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://explorer.cryptopros.us/api/getdifficulty');
        $hash = file_get_contents('http://explorer.cryptopros.us/api/getnetworkhashps');

        return compact('diff','hash');
    }
}