<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutopartesController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\PedidosController;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', fn () => view('auth.login'))->name('login');

Route::get('/autopartes',                [AutopartesController::class, 'index'] )->name('autopartes.index');
Route::get('/autopartes/nueva',          [AutopartesController::class, 'create'])->name('autopartes.create');
Route::get('/autopartes/{id}/editar',    [AutopartesController::class, 'edit']  )->name('autopartes.edit');

Route::get('/inventarios',               [InventariosController::class, 'index'])->name('inventarios.index');

Route::get('/pedidos',                   [PedidosController::class, 'index']    )->name('pedidos.index');
Route::get('/pedidos/{id}',              [PedidosController::class, 'show']     )->name('pedidos.show');
