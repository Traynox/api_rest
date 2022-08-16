<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/personas',[PersonaController::class,'index']);
// Route::post('/personas',[PersonaController::class,'store']);
// Route::put('/personas/{id}',[PersonaController::class,'update']);
// Route::delete('/personas/{id}',[PersonaController::class,'destroy']);
// Route::apiResource('personas',PersonaController::class);

Route::post('register', [UserController::class,'register']);
Route::post('update', [UserController::class,'update']);
Route::post('login', [UserController::class,'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user',[UserController::class,'getAuthenticatedUser']);
    Route::post('logout',[UserController::class,'logout']);
});


Route::apiResource('clientes', ClienteController::class);
Route::apiResource('proveedores', ProveedorController::class);
Route::apiResource('instalaciones', InstalacionController::class);
Route::apiResource('motores', MotorController::class);
Route::apiResource('compras', CompraController::class);

Route::get('clientes/limit/{limit}',[ClienteController::class,'indexLimit']);
Route::get('proveedores/limit/{limit}',[ProveedorController::class,'indexLimit']);
Route::get('instalaciones/limit/{limit}',[InstalacionController::class,'indexLimit']);
Route::get('motores/limit/{limit}',[MotorController::class,'indexLimit']);
Route::get('compras/limit/{limit}',[CompraController::class,'indexLimit']);

Route::get('clientes/filter/paginate/{paginate}/{buscar?}',[ClienteController::class,'indexFilter']);
Route::get('proveedores/filter/paginate/{paginate}/{buscar?}',[ProveedorController::class,'indexFilter']);
Route::get('instalaciones/filter/paginate/{paginate}/{buscar?}',[InstalacionController::class,'indexFilter']);
Route::get('motores/filter/paginate/{paginate}/{buscar?}',[MotorController::class,'indexFilter']);
Route::get('compras/filter/paginate/{paginate}/{buscar?}',[CompraController::class,'indexFilter']);



//Route::resource('proveedores', ProveedorController::class)->except(['create','edit']);