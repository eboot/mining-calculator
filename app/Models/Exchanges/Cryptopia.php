<?php


namespace App\Models\Exchanges;


use App\Models\Exchange;
use App\Models\Tick;

class Cryptopia
{

    const DB_NAME = "Cryptopia";


    public function updatePrices()
    {
        $model = Exchange::getByName(self::DB_NAME);
        $coins = $model->coins;
        $api_data = json_decode(file_get_contents('https://www.cryptopia.co.nz/api/GetMarkets/BTC'), true)['Data'];

        $tickers =[];
        foreach ($coins as $coin) {
            $tickers[] = $coin->pivot->ticker_string;
        }

        $filtered = array_filter($api_data, function ($v) use ($tickers) {
            return in_array($v['Label'], $tickers);
        });

        foreach ($filtered as $row) {
            foreach ($coins as $coin) {
                if ($coin->pivot->ticker_string == $row['Label']) {
                    $model->coins()->updateExistingPivot($coin->id, [
                        'last_price' => $row['LastPrice'],
                        'volume' => bcmul($row['Volume'],$row['LastPrice'], 4),
                        'updated_at' => time(),
                        'variation_24hr' =>  $row['Change'],
                    ]);
                    $coin->ticks()->create([
                        'exchange_id' => $model->id,
                        'last_price' => $row['LastPrice'],
                        'tick_time' => time()
                    ]);
                }
            }
        }

    }
}