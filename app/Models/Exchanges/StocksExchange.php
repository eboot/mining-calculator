<?php


namespace App\Models\Exchanges;


use App\Models\Exchange;
use App\Models\Tick;

class StocksExchange
{

    const DB_NAME = "Stocks.Exchange";


    public function updatePrices()
    {
        $model = Exchange::getByName(self::DB_NAME);
        $coins = $model->coins;
        $api_data = json_decode(file_get_contents('https://stocks.exchange/api2/ticker'), true);

        $tickers =[];
        foreach ($coins as $coin) {
            $tickers[] = $coin->pivot->ticker_string;
        }

        $filtered = array_filter($api_data, function ($v) use ($tickers) {
            return in_array($v['market_name'], $tickers);
        });

        foreach ($filtered as $row) {
            foreach ($coins as $coin) {
                if ($coin->pivot->ticker_string == $row['market_name']) {
                    $model->coins()->updateExistingPivot($coin->id, [
                        'last_price' => $row['last'],
                        'volume' => bcmul($row['vol'], $row['last'], 4),
                        'updated_at' => $row['updated_time'],
                        'variation_24hr' =>  ($row['last'] -$row['lastDayAgo']) / abs(($row['last'] + $row['lastDayAgo']) / 2) * 100,
                    ]);
                    $coin->ticks()->create([
                        'exchange_id' => $model->id,
                        'last_price' => $row['last'],
                        'tick_time' => $row['updated_time']
                    ]);
                }
            }
        }

    }
}