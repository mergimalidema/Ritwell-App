<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Log;
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
});
//Route::post('/webhook', 'WebhookController@handle');
//Route::post('/webhook', [WebhookController::class, 'handle']);
Route::post('/webhooks/github', function() {
    // Code to handle webhook request and pull changes from Github
    $output = shell_exec('cd /var/www/Ritwell-App && git pull origin master 2>&1');
    Log::info("Git pull output: \n" . $output);

});

