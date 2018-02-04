<?php

namespace App\Console\Commands;

use App\Models\Coin;
use Illuminate\Console\Command;

class GetHashrates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:hashrates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update coins hashrates';

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
        $coins = Coin::all();
        foreach ($coins as $coin) {
            $coin->updateHashRateAndDiff();
        }
    }
}
