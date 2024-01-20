<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Administracion\Inmueble\InmuebleController;
use App\Http\Controllers\Administracion\Inmueble\ResidenteController;
use App\Http\Controllers\Administracion\Inmueble\PropietarioController;
use App\Http\Controllers\Administracion\Condominios\CondominioController;



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

    // Rutas de subusarios
    Route::get('subusuarios', [UserController::class, 'indexSubUser']);
    Route::post('subusuarios', [UserController::class, 'storeSubUser']);
    Route::get('subusuarios/{id}', [UserController::class, 'showSubUser']);
    Route::delete('subusuarios/{id}', [UserController::class, 'destroySubUser']);
    // Route::put('subusuarios/{id}', [UserController::class, 'storeSubUser']);

    Route::post('logout', [AuthController::class, 'logout']);

    // Ruta Condominio
    Route::apiResource('condominios', CondominioController::class);

    // Ruta Propietario
    Route::apiResource('propietarios', PropietarioController::class);

    // Ruta Residente
    Route::apiResource('residentes', ResidenteController::class);

    // Ruta Inmueble
    Route::apiResource('inmuebles', InmuebleController::class);

    // Rutas Planes
    Route::apiResource('planes', PlanController::class);
});
