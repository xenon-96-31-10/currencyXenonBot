<?php

namespace App\Conversations;

use App\Models\Subscribe;
use App\Models\Log;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class LogConversation extends Conversation
{
    protected $chat_id;
    protected $chat;
    protected $logs;
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->chat_id = $this->bot->getUser()->getId();
        $this->chat = Subscribe::where('chat_id', $this->chat_id)->first();
        $this->logs = $this->chat->log;
        $this->Logs();
    }

    private function Logs()
    {
      foreach ($this->logs as $log) {
        $this->bot->typesAndWaits(1);
        $this->say('Запрос от '.$log->created_at->format('d.m.Y H:i').' Доллар тогда был: '.$log->value.' р');
      }

      if($this->logs->count() < 1){
        $this->bot->typesAndWaits(1);
        $this->say('История пуста!');
      }


    }
}
