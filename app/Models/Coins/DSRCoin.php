<?php
namespace App\Models\Coins;


class  DSRCoin extends GenericCoin {

    public function getReward()
    {
        //return 2222222/(((Difficulty+2600)/9)^2)
    }

    public function getHashrateAndDiff()
    {
        $diff = 0;
        $hash = 0;

        $diffchart = json_decode(file_get_contents('https://altmix.org/ajax/coins/13-Desire/difficultyChartData/day'), true);
        if (is_array($diffchart)) {
            $diff = $diffchart[count($diffchart) -1]['d'];
        }

        $page = file_get_contents('https://www.crypto-coinz.net/coin-info/?22-Desire-DSR-NeoScrypt-calculator');
        if (preg_match("#Network Hashrate: </span>(.*) H/s <br/>#miU", $page, $matches)) {
            $hash = str_replace(',', '', $matches[1]);
        }

        return compact('diff','hash');
    }


}