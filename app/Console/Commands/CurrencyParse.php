<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Currency;

class CurrencyParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command help to get new currencies value';

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
        $client = new Client();
        $response = $client->request('get', 'https://www.cbr-xml-daily.ru/daily_json.js');
        $data = json_decode($response->getBody()->getContents());
        $usd = Currency::updateOrCreate(['name' => 'USD'], ['value' => $data->Valute->USD->Value]);
        return 200;
    }
}
