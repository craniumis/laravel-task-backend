<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');

Route::group(["middleware" => "auth:sanctum"], function (){
    Route::resource('/companies', 'CompanyController');
    Route::resource('/employees', 'EmployeeController');
    Route::post('/logout', function(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(["status"=>true, "message"=>"User logout successfully.", "data"=>[]]);
    })->name("logout");
});


