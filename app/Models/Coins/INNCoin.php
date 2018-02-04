<?php
namespace App\Models\Coins;

class  INNCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('http://explorer.innovacoin.info/api/getdifficulty');
        $hash = file_get_contents('http://explorer.innovacoin.info/api/getnetworkhashps');

        return compact('diff','hash');
    }
}