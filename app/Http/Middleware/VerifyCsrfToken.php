<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //Добавление крючков для ботов в исключения проверки csrf
        '/xvib2xnh3420go61rfb2489smefpdtgo7vzdx815lmu59iuiqw/webhook',
    ];
}
