<?php

namespace App\Models;

use App\Models\Algos\GenericAlgo;
use Illuminate\Database\Eloquent\Model;

class Algo extends Model
{

    protected $guarded = ['id'];

    /**
     * @var GenericAlgo
     */
    protected $_worker;

    /**
     * @return GenericAlgo
     */
    public function getWorkerAttribute()
    {
        if (!$this->_worker) {
            if (file_exists(base_path('app/Models/Algos/' . $this->name . 'Algo.php'))) {
                $class = "\App\Models\Algos\\" . $this->name . 'Algo';
                $this->_worker = new $class($this);
            } else {
                $this->_worker = new GenericAlgo($this);
            }
        }
        return $this->_worker;
    }

    public function coins()
    {
        return $this->hasMany(Coin::class);
    }

    public function getReward(Coin $coin, $hashRate)
    {
        return $this->worker->getReward($coin, $hashRate);
    }
}
