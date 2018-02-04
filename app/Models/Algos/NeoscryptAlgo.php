<?php
namespace App\Models\Algos;

class  NeoscryptAlgo extends GenericAlgo {


    public function getReward($coin, $hashrate)
    {

        $userRatio = $hashrate * $this->parent->hash_ratio / $coin->current_hash_rate;
        $blocksPerMin = 60.0 / $coin->block_time;
        $coinPermin = $blocksPerMin * $coin->block_reward;
        $earningsHour = $userRatio * $coinPermin * 60;

        return [
            'current' =>
                [
                    'hour' => $earningsHour,
                    'day' => $earningsHour * 24,
                ]
        ];
    }
}