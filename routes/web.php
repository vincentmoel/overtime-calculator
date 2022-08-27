<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OvertimeGroupController;
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

Route::get('/',[HomeController::class,'index'])->middleware('revalidate');
Route::post('/login',[AuthController::class,'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/logout', function () { return redirect('/'); });

Route::group(['middleware' => ['guest', 'revalidate']], function () {
    Route::get('/login',[AuthController::class,'index'])->name('login');
    
});

Route::get('/', [OvertimeGroupController::class,'index']);
