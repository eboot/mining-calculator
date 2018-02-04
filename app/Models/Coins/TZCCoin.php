<?php
namespace App\Models\Coins;

class  TZCCoin extends GenericCoin {

    public function getHashrateAndDiff()
    {
        $diff = file_get_contents('https://chainz.cryptoid.info/tzc/api.dws?q=getdifficulty');
        $hash = 0;
        $page = file_get_contents('https://trezarcoin.com/netstats/');
        if (preg_match("#<h3>Current Hashrate in h/s: (\d+)</h3>#miU", $page, $matches)) {
            $hash = $matches[1];
        }

        return compact('diff','hash');
    }
}