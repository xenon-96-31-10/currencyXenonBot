<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Models\Log;
use App\Models\Currency;
use Carbon\Carbon;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\LogConversation;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class BotManController extends Controller
{
  public function handle(){

    $config = [
        // Your driver-specific configuration
        "telegram" => [
           "token" => \\API_TOKEN
        ],
        'user_cache_time' => 30000 ,
        'talk_cache_time' => 30000 ,
    ];

    // Load the driver(s) you want to use
    DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

    // Create an instance
    $botman = BotManFactory::create($config, new LaravelCache());

    // Give the bot something to listen for.
    $botman->hears('/start', function (BotMan $bot) {
      $bot->typesAndWaits(1);
      $chat_id = $bot->getUser()->getId();
      $name = $bot->getUser()->getFirstName();
      $bot->reply('Добро пожаловать к нам, '.$name.'! Просмотрите доступные команды и начинайте пользоваться.🍀');

      if(Subscribe::where('chat_id', $chat_id)->first() === null){
        $user = new Subscribe();
        $user->chat_id = $chat_id;
        $user->name = $name;
        $user->subscribe = 0;
        $user->save();
      }

    });

    $botman->hears('/menu', function (BotMan $bot) {
      $this->showMainMenu($bot);
    });

    $botman->hears('Курс доллара 💵|/usdrate', function (BotMan $bot) {
        $bot->typesAndWaits(1);
        $chat_id = $bot->getUser()->getId();
        $name = $bot->getUser()->getFirstName();
        $chat = Subscribe::where('chat_id', $chat_id)->first();


        $usd = Currency::where('name', 'USD')->first();
        $value = $usd->value;
        $update = $usd->updated_at->format('d.m.Y');

        $log = new Log();
        $log->value = $value;
        $log->chat()->associate($chat)->save();

        $bot->reply('Курс долара равен '.$value.' р. Данные обновились: '.$update.' Данные автоматически беруться с официального апи ЦБ РФ🤞');
    });

    $botman->hears('История запросов|/log', function($bot) {
     $bot->startConversation(new LogConversation());
    })->stopsConversation();

    $botman->hears('Удалить историю|/deletelog', function($bot) {
      $bot->typesAndWaits(1);
      $chat = Subscribe::where('chat_id', $bot->getUser()->getId())->first();
      $chat->log()->delete();
      $bot->reply('История удалена!');
    });

    $botman->hears('Оформить подписку|/subscribe', function (BotMan $bot) {
        $bot->typesAndWaits(1);
        $user = Subscribe::updateOrCreate(['chat_id' => $bot->getUser()->getId()], ['subscribe' => 1, 'name' => $bot->getUser()->getFirstName()]);
        $bot->reply('Поздравляем, '.$user->name.'! Вы успешно подписались на ежедневное получение актуального курса доллара в 13-00 по Москве.🍀');
    });

    $botman->hears('Отменить подписку|/unsubscribe', function (BotMan $bot) {
        $bot->typesAndWaits(1);
        $user = Subscribe::updateOrCreate(['chat_id' => $bot->getUser()->getId()], ['subscribe' => 0, 'name' => $bot->getUser()->getFirstName()]);
        $bot->reply('Мы успешно Вас отписали, '.$user->name.'! Будем ждать Вашей подписки снова!🍀');
    });

    $botman->hears('Номер чата', function (BotMan $bot) {
        $bot->typesAndWaits(1);
        $bot->reply($bot->getUser()->getId());
    });

    // Start listening
    $botman->listen();

  }

  public function showMainMenu($bot){
    $keyboard = Keyboard::create()
        ->type(Keyboard::TYPE_KEYBOARD)
        ->addRow(KeyboardButton::create('Оформить подписку')->callbackData('Оформить подписку'),
                 KeyboardButton::create('Отменить подписку')->callbackData('Отменить подписку'))
        ->addRow(KeyboardButton::create('Курс доллара 💵')->callbackData('Курс доллара 💵'),
                 KeyboardButton::create('История запросов')->callbackData('История запросов'),
                 KeyboardButton::create('Удалить историю')->callbackData('Удалить историю'))
        ->toArray();
      $bot->ask('Выберите действие', function (Answer $answer) {
        // some stuff
      }, $keyboard);
  }

}
