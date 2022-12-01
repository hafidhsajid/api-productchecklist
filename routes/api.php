<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Checklist;
use App\Http\Controllers\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', AuthController::class . '@register');
Route::post('/login', AuthController::class . '@login');
Route::get('/logout', AuthController::class . '@logout');
Route::group(['middleware' => ['jwt.verify']], function() {

    // Route::get('/checklist', Products::class . '@index');
    // Route::post('/checklist', Products::class . '@create');
    Route::get('/checklist', Checklist::class . '@index');
    Route::post('/checklist', Checklist::class . '@create');
    Route::delete('/checklist/{id}', Checklist::class . '@destroy');

});
