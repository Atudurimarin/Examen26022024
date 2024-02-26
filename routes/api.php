<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:sanctum')->get('contactos/index', [ContactoController::class, 'index'])->name('api.v1.contactos.index');

Route::middleware(['auth:sanctum', 'abilities:create,delete'])->post('contactos', [ContactoController::class, 'store'])->name('api.v1.contactos');

Route::middleware(['auth:sanctum', 'abilities:create,delete'])->delete('contactos/{contacto}', [ContactoController::class, 'destroy'])->name('api.v1.contactos.destroy');

Route::middleware('auth:sanctum')->get('contactos/{contacto}', [ContactoController::class, 'show'])->name('api.v1.contactos.show');

//LAS RUTAS PARA CREAR Y BORRAR ESTÁN PROTEGIDAS CON abilities NO LO VUELVO A PONER EN LOS MÉTODOS DEL CONTROLADOR


Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);


