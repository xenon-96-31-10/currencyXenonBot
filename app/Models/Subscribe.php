<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_id',
        'name',
        'subscribe',
    ];

    /**
     * Получение истории запросов пользователя, даже без подписки.
     * @return mixed
     */
    public function log()
    {
      return $this->hasMany(Log::class,'chat_id');
    }
}
