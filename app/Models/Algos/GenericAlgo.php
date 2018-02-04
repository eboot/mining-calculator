<?php
namespace App\Models\Algos;

class  GenericAlgo {

    protected $parent;

    public function __construct(\App\Models\Algo $algo)
    {
        $this->parent = $algo;
    }

    public function getReward($coin, $hashrate)
    {
        return [];
    }
}