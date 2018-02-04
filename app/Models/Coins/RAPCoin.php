<?php
namespace App\Models\Coins;

class  RAPCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://explorer.our-rapture.com/api/getdifficulty');
        $hash = file_get_contents('http://explorer.our-rapture.com/api/getnetworkhashps');

        return compact('diff','hash');
    }
}