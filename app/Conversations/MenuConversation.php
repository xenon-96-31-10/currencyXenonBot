<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class MenuConversation extends Conversation
{

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->showMainMenu();
    }

    private function showMainMenu()
    {

    }
}
