<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\OvertimeGroupController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->middleware('revalidate');
Route::post('/login', [AuthController::class, 'authenticate']);


Route::group(['middleware' => ['guest', 'revalidate']], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function(){
        return view('home');
    });

    // Auth Controller
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/logout', function () {
        return redirect('/');
    });

    // Overtime Controller
    Route::get('/overtimes', [OvertimeGroupController::class, 'index']);
    Route::get('/overtimes/create', [OvertimeGroupController::class, 'create']);
    Route::post('/overtimes/store', [OvertimeGroupController::class, 'store']);
    Route::get('/overtimes/{overtimeGroup}/edit', [OvertimeGroupController::class, 'edit']);
    Route::patch('/overtimes/{overtimeGroup}', [OvertimeGroupController::class,'update']);
    Route::delete('/overtimes/{overtimeGroup}', [OvertimeGroupController::class,'destroy']);
    Route::get('/overtimes/jquery/add-event/{increment}', [OvertimeGroupController::class, 'addEvent']);
    Route::get('/overtimes/jquery/add-overtime', [OvertimeGroupController::class, 'addOvertime']);

    Route::get('/result', [OvertimeGroupController::class, 'result']);

    // Config Controller
    Route::get('/configs', [ConfigController::class, 'index']);
    Route::post('/configs/{config}', [ConfigController::class, 'update']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::patch('/users/{user}', [UserController::class, 'update']);

});
