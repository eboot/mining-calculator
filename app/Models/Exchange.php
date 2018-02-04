<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{

    public $timestamps = false;

    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function coins()
    {
        return $this->belongsToMany(Coin::class)->withPivot('ticker_string', 'last_price', 'variation_24hr', 'volume');
    }
}
