<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Crypto;
use Illuminate\Support\Facades\Http;

class fetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchData:coingecko';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and save data in the database from coingecko';

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
     * @return int
     */
    public function handle()
    {
        echo 'Started Working'. PHP_EOL;
        $response = Http::get('https://api.coingecko.com/api/v3/coins/list?include_platform=true');




        $data = $response->json();

        foreach ($data as $key => $row) {
            $insert = Crypto::create([
                'cid' => $row['id'],
                'symbol' => $row['symbol'],
                'name' => $row['name'],
                'platform' => serialize($row['platforms'])
            ]);

            if ($key % 1000 === 0) {
                echo $key . ' records are saved'. PHP_EOL;
            }
        }


        if ($insert) {
            echo 'Data saved in the database'. PHP_EOL;
        }
    }
}
