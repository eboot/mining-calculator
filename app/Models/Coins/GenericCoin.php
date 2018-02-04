<?php
namespace App\Models\Coins;

class  GenericCoin {

    protected $parent;

    public function __construct(\App\Models\Coin $coin)
    {
        $this->parent = $coin;
    }

    public function getReward()
    {
        return $this->parent->reward;
    }

    public function updateHashrate()
    {

    }

    public function getHashrateAndDiff()
    {
        $diff = 0;
        $hash = 0;

        return compact('diff','hash');
    }
}