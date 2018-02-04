<?php
namespace App\Models\Coins;

class  VIVOCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://vivo.explorerz.top:3003/api/getdifficulty');
        $hash = file_get_contents('http://vivo.explorerz.top:3003/api/getnetworkhashps');

        return compact('diff','hash');
    }
}