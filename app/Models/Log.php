<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'chat_id',
    ];

    /**
     * Связь один ко многим между таблицей, которая хранит номер чата и информацию о подписке с историей запросов.
     * Данное разделение позволит повысить конфиденциальность данных пользователя и удалять все данные по желанию.
     * @return [type] [description]
     */
    public function chat()
    {
      return $this->belongsTo(Subscribe::class);
    }

}
