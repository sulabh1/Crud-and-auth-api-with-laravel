<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use GuzzleHttp\Promise\Create;
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

//Route::resource('products', ProductController::class);

//public route

Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/search/{name}", [ProductController::class, "search"]);
Route::get("/products/{product}", [ProductController::class, "show"]);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);



//protected route
Route::group(["middleware" => ['auth:sanctum']], function () {
    Route::patch("/products/{product}", [ProductController::class, "update"]);
    Route::delete('/products/{product}', [ProductController::class, "destroy"]);
    Route::post("/products", [ProductController::class, "store"]);
    Route::post("/logout", [AuthController::class, "logout"]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
