<?php

use App\Http\Controllers\Administracion\Configuracion\AdminFirmaController;
use App\Http\Controllers\Administracion\Configuracion\AreaComunaleController;
use App\Http\Controllers\Administracion\Configuracion\BancoController;
use App\Http\Controllers\Administracion\Configuracion\FirmaEmailController;
use App\Http\Controllers\Administracion\Configuracion\PresidenteTesoreroController;
use App\Http\Controllers\Administracion\Configuracion\RelacioneController;
use App\Http\Controllers\Administracion\Configuracion\SecuencialeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Administracion\Inmueble\InmuebleController;
use App\Http\Controllers\Administracion\Inmueble\ResidenteController;
use App\Http\Controllers\Administracion\Inmueble\PropietarioController;
use App\Http\Controllers\Administracion\Condominios\CondominioController;
use App\Http\Controllers\Administracion\Configuracion\EmpleadoController;
use App\Http\Controllers\Administracion\Configuracion\ProveedoreController;

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

    // Rutas Relaciones Familiares
    Route::apiResource('relaciones-familiares', RelacioneController::class);

    // Rutas Secuenciales de Documentos
    Route::apiResource('secuencias-documentos', SecuencialeController::class);

    // Rutas Firma Administrador
    Route::apiResource('firma-administrador', AdminFirmaController::class);

    // Rutas Nombre Presidente y Tesorero
    Route::apiResource('nombre-presi-teso', PresidenteTesoreroController::class);

    // Rutas Cuentas Bancarias
    Route::apiResource('bancos', BancoController::class);

    // Rutas Areas Comunales
    Route::apiResource('areas-comunales', AreaComunaleController::class);

    // Rutas Firma Administrador Email
    Route::apiResource('firma-email', FirmaEmailController::class);

    // Rutas Proveedores
    Route::apiResource('proveedores', ProveedoreController::class);

    // Rutas Empleados
    Route::apiResource('empleados', EmpleadoController::class);
});
