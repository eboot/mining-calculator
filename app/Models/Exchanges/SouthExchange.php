<?php


namespace App\Models\Exchanges;


use App\Models\Exchange;
use App\Models\Tick;

class SouthExchange
{

    const DB_NAME = "SouthExchange";


    public function updatePrices()
    {
        $model = Exchange::getByName(self::DB_NAME);
        $coins = $model->coins;
        $api_data = json_decode(file_get_contents('https://www.southxchange.com/api/prices'), true);

        $tickers =[];
        foreach ($coins as $coin) {
            $tickers[] = $coin->pivot->ticker_string;
        }

        $filtered = array_filter($api_data, function ($v) use ($tickers) {
            return in_array($v['Market'], $tickers);
        });

        foreach ($filtered as $row) {
            foreach ($coins as $coin) {
                if ($coin->pivot->ticker_string == $row['Market']) {
                    $model->coins()->updateExistingPivot($coin->id, [
                        'last_price' => $row['Last'],
                        'volume' => bcmul($row['Volume24Hr'],$row['Last'], 4),
                        'updated_at' => time(),
                        'variation_24hr' =>  $row['Variation24Hr'],
                    ]);
                    $coin->ticks()->create([
                        'exchange_id' => $model->id,
                        'last_price' => $row['Last'],
                        'tick_time' => time()
                    ]);
                }
            }
        }

    }
}