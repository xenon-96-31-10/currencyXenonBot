<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();
Route::post('/api/get-chats', [App\Http\Controllers\ApiController::class, 'getChats'])->name('api.getChats');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/**
 * С помощью этого крючка бот соединяется с приложением. Таких крючков можно делать множество.
 * @var [type]
 */
Route::post('/xvib2xnh3420go61rfb2489smefpdtgo7vzdx815lmu59iuiqw/webhook', [App\Http\Controllers\BotManController::class, 'handle'])->name('botman');
