<?php

namespace App\Console\Commands;

use App\Models\Exchanges\Cryptopia;
use App\Models\Exchanges\SouthExchange;
use App\Models\Exchanges\StocksExchange;
use Illuminate\Console\Command;

class GetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Exchnage prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $se = new StocksExchange();
        $se->updatePrices();

        $cr = new Cryptopia();
        $cr->updatePrices();

        $sth = new SouthExchange();
        $sth->updatePrices();
    }
}
