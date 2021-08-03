<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Models\Log;
use App\Models\Currency;

class ApiController extends Controller
{
  public function getChats(){
    $chats = Subscribe::all();
    $data = array();
    foreach ($chats as $chat) {

      $data[] = [
        'id' => $chat->id,
        'title' => $chat->chat_id,
        'description' => $chat->name,
        'data' => $chat->subscribe === 1 ? 'Подписка оформлена' : 'Без подписки',
      ];
    }
    return response()->json($data);
  }
}
