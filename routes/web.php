<?php

use App\Models\openTrivia;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\questionCategory;
use App\Models\questions;
use App\Models\tournament;
use App\Models\tournamentPoints;
use App\Models\useful;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/dashboard', '/', 301);

Route::middleware('auth')->group(function () {

    Route::view('/',                 'welcome', array('tournaments'=>tournament::tournaments()));
    Route::view('/new',              'newtournament');

    Route::get ('/lobby',            'App\Http\Controllers\tournamentController@lobbyPage');
    Route::get ('/play',             'App\Http\Controllers\tournamentController@playPage');
    Route::get ('/settings',         'App\Http\Controllers\tournamentController@settingsPage');

    Route::post('/result',           'App\Http\Controllers\tournamentController@result');
    Route::post('/createtournament', 'App\Http\Controllers\tournamentController@createtournament');
    Route::post('/changesetting',    'App\Http\Controllers\tournamentController@changeSetting');

});

Route::get('test',function(){
    print_r(tournament::tournaments());

});
