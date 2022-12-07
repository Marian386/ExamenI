<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\MediaController;

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
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    Route::get('/dashboard',[SocialController::class,'showpost'])->name('dashboard');

});


Route::get('linkedin/login',[SocialController::class,'provider'])->name('linkedin.dashboard');
Route::get('linkedin/callback',[SocialController::class,'providerCallback'])->name('linkedin.user');
Route::get('/dashboar',[SocialController::class,'showpost']);

Route::post('linkedin/post',[SocialController::class,'postRequestLinkedin']); 
Route::post('post',[SocialController::class,'savetypepost']);


Route::get('twitter',[MediaController::class, 'connect_twitter'])->name('media');
Route::get('/twitter/cbk', [MediaController::class, 'twitter_cbk']);
