<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\LegislacaoController;
use App\Http\Controllers\InformacaoController;

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');

// Documentos
Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
Route::get('/documentos/{documento}', [DocumentoController::class, 'show'])->name('documentos.show');
Route::get('/documentos/{documento}/download', [DocumentoController::class, 'download'])->name('documentos.download');
Route::get('/documentos/{documento}/preview', [DocumentoController::class, 'preview'])->name('documentos.preview');

// Financeiro
Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiros.index');
Route::get('/financeiro/{financeiro}', [FinanceiroController::class, 'show'])->name('financeiros.show');
Route::get('/financeiro/{financeiro}/download', [FinanceiroController::class, 'download'])->name('financeiros.download');
Route::get('/financeiro/{financeiro}/preview', [FinanceiroController::class, 'preview'])->name('financeiros.preview');

// Legislação
Route::get('/legislacao', [LegislacaoController::class, 'index'])->name('legislacoes.index');
Route::get('/legislacao/{legislacao}', [LegislacaoController::class, 'show'])->name('legislacoes.show');
Route::get('/legislacao/{legislacao}/download', [LegislacaoController::class, 'download'])->name('legislacoes.download');
Route::get('/legislacao/{legislacao}/preview', [LegislacaoController::class, 'preview'])->name('legislacoes.preview');

// Informações
Route::get('/informacoes', [InformacaoController::class, 'index'])->name('informacoes.index');
Route::get('/informacoes/{informacao}', [InformacaoController::class, 'show'])->name('informacoes.show');
Route::get('/informacoes/{informacao}/download', [InformacaoController::class, 'download'])->name('informacoes.download');

// Notícias
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

    // Financeiro (CRUD completo no admin)
    Route::resource('financeiros', FinanceiroController::class);

    // Legislação (CRUD completo no admin)
    Route::resource('legislacoes', LegislacaoController::class);

    // Informações (CRUD completo no admin)
    Route::resource('informacoes', InformacaoController::class);

    // Notícias (CRUD completo no admin)
    Route::resource('noticias', NoticiaController::class);
});