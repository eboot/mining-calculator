<?php

namespace App\Models;

use App\Models\Coins\GenericCoin;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{

    protected $guarded = ['id'];
    /**
     * @var GenericCoin
     */
    protected $_worker;

    public function getWorkerAttribute()
    {
        if (!$this->_worker) {
            if (file_exists(base_path('app/Models/Coins/' . $this->ticker . 'Coin.php'))) {
                $class = "\App\Models\Coins\\" . $this->ticker . 'Coin';
                $this->_worker = new $class($this);
            } else {
                $this->_worker = new GenericCoin($this);
            }
        }
        return $this->_worker;
    }

    public function ticks()
    {
        return $this->hasMany(Tick::class);
    }

    public function algo()
    {
        return $this->belongsTo(Algo::class);
    }

    public function hashRateTicks()
    {
        return $this->hasMany(HashRateTick::class);
    }

    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class)->withPivot('ticker_string', 'last_price', 'variation_24hr', 'volume');
    }

    public function updateHashRateAndDiff()
    {
        $data = $this->worker->getHashrateAndDiff();
        $this->update(['current_hash_rate' => $data['hash'], 'current_diff' => $data['diff']]);
        $this->hashRateTicks()->create(['difficulty' => $data['diff'], 'hashrate' => $data['hash'], 'tick_time' => time()]);
    }

    public function getReward($hashRate)
    {
        return $this->algo->getReward($this, $hashRate);
    }

}
