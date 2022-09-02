<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//middleware('auth'): necessita que o usuário esteja logado para acessar determinada rota

//página home (index)
Route::get('/', [EventController::class, 'index']);

//chamando tela de cadastro de evento (create)
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');

//salvando dados do formulário (post)
Route::post('/events', [EventController:: class, 'store']);

//mostrando um dado específico
Route::get('/events/{id}', [EventController::class, 'show']);

//chamando tela dos meus eventos (grid dos meus eventos)
Route::get('/dashboard', [EventController:: class, 'dashboard'])->middleware('auth');

//deletando dados (delete)
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

//chamando tela de edição (edit)
Route::get('/events/edit/{id}', [EventController:: class, 'edit'])->middleware('auth');

//atualizando dados do formulário e salvando (update)
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');

//participando do evento (join)
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');

//removendo presença no evento
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');
