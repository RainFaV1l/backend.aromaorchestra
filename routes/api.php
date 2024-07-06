<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::apiResources([
   'products' => \App\Http\Controllers\Api\ProductController::class,
   'categories' => \App\Http\Controllers\Api\CategoryController::class,
   'orders' => \App\Http\Controllers\Api\OrderController::class,
   'subscribes' => \App\Http\Controllers\Api\SubscribeController::class,
    'reviews' => \App\Http\Controllers\Api\ReviewController::class,
    'deliveries' => \App\Http\Controllers\Api\DeliveryController::class,
]);
