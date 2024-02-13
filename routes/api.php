<?php

use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\TaxDomicileController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout/all', [AuthController::class, 'logoutAll']);
    });
});

Route::prefix('v1')->group(function () {
    Route::prefix('tax-domicile/purchase')->group(function () {
        Route::post('/', [TaxDomicileController::class, 'purchase']);
        Route::post('webhook', [TaxDomicileController::class, 'webhook']);
    });
});
