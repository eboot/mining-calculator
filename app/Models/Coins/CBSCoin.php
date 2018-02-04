<?php
namespace App\Models\Coins;

class  CBSCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://exp.cerberuscoin.com/api/getdifficulty');
        $hash = file_get_contents('http://exp.cerberuscoin.com/api/getnetworkhashps');

        return compact('diff','hash');
    }
}