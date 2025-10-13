<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransacaoController;

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
Route::get('/documentos/{documento}', [DocumentoController::class, 'show'])->name('documentos.show');
Route::get('/documentos/{documento}/download', [DocumentoController::class, 'download'])->name('documentos.download');
Route::get('/documentos/{documento}/preview', [DocumentoController::class, 'preview'])->name('documentos.preview');
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/transacoes', [TransacaoController::class, 'index'])->name('transacoes.index');
Route::get('/transacoes/{transacao}', [TransacaoController::class, 'show'])->name('transacoes.show');

// Rotas de autenticação (login/logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas do admin (protegidas por middleware 'auth')
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Documentos (CRUD completo no admin)
    Route::resource('documentos', DocumentoController::class);

    // Notícias (CRUD completo no admin)
    Route::resource('noticias', NoticiaController::class);
});