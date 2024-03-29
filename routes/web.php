<?php

use App\Http\Controllers\AlltvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ElectController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\Updateuser;
use App\Http\Controllers\listdata;
use App\Http\Controllers\VertualController;
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

//Route::get('/', function () {
//    if (Auth()->user()) {
//        return redirect(route('dashboard'))
//            ->withSuccess('Signed in');
//
//    }else {
//        return view('welcome');
//    }
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');
Route::get('changepass', function () {
    return view('changepass');
})->name('changepass');
Route::post('pass1', [AuthController::class, 'pass1'])->name('pass1');
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('pass', [AuthController::class, 'updatepa'])->name('pass');
Route::get('update', [Updateuser::class, 'profile'])->name('update');
Route::post('update2', [Updateuser::class, 'profile1'])->name('update2');
Route::get('invoice', [AuthController::class, 'invoice'])->name('invoice');
Route::get('charges', [AuthController::class, 'charges'])->name('charges');
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('referal', [AuthController::class, 'refer'])->name('referal');
//Route::post('mp', [ResellerController::class, 'reseller'])->name('mp');
//Route::get('reseller', [ResellerController::class, 'sell'])->name('reseller');
//Route::get('upgrade', [ResellerController::class, 'apiaccess'])->name('upgrade');
Route::post('log', [AuthController::class, 'customLogin'])->name('log');
Route::post('payelect', [ElectController::class, 'payelect'])->name('payelect');
Route::post('verifye', [ElectController::class, 'verifyelect'])->name('verifye');
Route::get('elect', [ElectController::class, 'electric'])->name('elect');
Route::get('select', [AuthController::class, 'select'])->name('select');
Route::get('listdata', [listdata::class, 'list'])->name('listdata');
Route::get('listelect', [ElectController::class, 'listelect'])->name('listelect');
Route::get('listtv', [AlltvController::class, 'listtv'])->name('listtv');
Route::get('tv', [AlltvController::class, 'tv'])->name('tv');
Route::post('tvp', [AlltvController::class, 'paytv'])->name('tvp');
Route::post('verifytv', [AlltvController::class, 'verifytv'])->name('verifytv');
Route::get('airtime', [AuthController::class, 'airtime'])->name('airtime');
Route::post('time', [BillController::class, 'bill'])->name('time');
Route::post('data', [BillController::class, 'data'])->name('data');
Route::post('buydata', [AuthController::class, 'buydata'])->name('buydata');
Route::post('pre', [AuthController::class, 'pre'])->name('pre');
Route::post('bill', [BillController::class, 'bill'])->name('bill');
Route::get('fund', [FundController::class, 'fund'])->name('fund');
Route::get('tran/{reference}', [FundController::class, 'tran'])->name('tran');
Route::get('vertual', [VertualController::class, 'vertual'])->name('vertual');
});
require __DIR__.'/auth.php';
