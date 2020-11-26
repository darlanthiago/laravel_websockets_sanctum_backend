<?php

use App\Models\Message;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/message', function () {

    $message = new Message();

    $message->title = "Darlan Thiago";
    $message->body = "Esta mensagem é de teste";
    $message->save();
    $success = event(new App\Events\NewMessage($message));
    return $success;
});
