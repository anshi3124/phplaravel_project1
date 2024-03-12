<?php
use App\Http\Controllers\userController;
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

Route::get('/',[UserController::class,'welcome']);
Route::get('user/reg',[UserController::class,'index']);
Route::post('/userregistration',[UserController::class,'signupAction']);
Route::post('/userlogin',[UserController::class,'login']);
Route::group(['prefix' => 'user','middleware' => ['web','isuser']],function(){
    
    Route::get('/CustDesh',[UserController::class,'viewDesh']);
    Route::get('/logout',[UserController::class,'logout']);
});
