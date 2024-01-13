<?php

use App\Http\Controllers\Administracion\Condominios\CondominioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Rutas registo y login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Todas las rutas que agreguemos aqui estan protegidas por que debe existir un usuario autenticado y un token
Route::middleware(['auth:sanctum'])->group(function () {

    // Rutas de usuario
    Route::apiResource('usuarios', UserController::class);
    Route::get('/usuarios-recursos', [UserController::class, 'recursos']);

    Route::post('logout', [AuthController::class, 'logout']);

    // Ruta Condominio
    Route::apiResource('condominios', CondominioController::class);

    // Rutas Planes
    Route::apiResource('planes', PlanController::class);
});
