<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as LoginController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AreaController;
use App\Session;

Auth::routes();

Route::prefix('/campaign')->group(function () {
    Route::get('{campaign}/report', 'CampaignController@report')->name('campaign.report');
    Route::resource('{campaign}/ticket', 'Campaign_ticketController')->only(['create', 'store']);
    Route::resource('{campaign}/session', 'SessionController')->except(['index', 'detroy']);
    Route::resource('{campaign}/area', 'AreaController')->only(['create', 'store']);
    Route::resource('{campaign}/place', 'PlaceController')->only(['create', 'store']);
});
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/', 'CampaignController@index')->name('home');
Route::resource('/campaign', 'CampaignController');
Route::resource('/', 'CampaignController');
