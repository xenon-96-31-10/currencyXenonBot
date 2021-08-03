<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BotManController;
use App\Models\Currency;
use App\Models\Subscribe;
use BotMan\BotMan\Drivers\DriverManager;

class BotMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comand to send message';

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
      $chats = Subscribe::where('subscribe',1)->get();
      $usd = Currency::where('name', 'USD')->first();
      $value = $usd->value;
      $update = $usd->updated_at->format('d.m.Y');
      $msg ='Курс долара равен '.$value.' р. Данные обновились: '.$update.' Данные автоматически беруться с официального апи ЦБ РФ🤞';
      $botman = resolve('botman');
      foreach ($chats as $chat) {
        $botman->say($msg, $chat->chat_id, DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class));
      }
    }
}
