<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\AdminDashboardController;

// Rota inicial do site
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas de Autenticação Aluna (Padrão)
Route::get('/login', [AutenticacaoController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AutenticacaoController::class, 'login'])->defaults('tipo', 'aluna');

// Rota de Login Mentora via URL
Route::get('/mentora', [AutenticacaoController::class, 'mostrarLoginMentora'])->name('mentora.login');
Route::post('/mentora/login', [AutenticacaoController::class, 'login'])->defaults('tipo', 'mentora')->name('mentora.post_login');

// Rota de Login Admin via URL
Route::get('/admin', [AutenticacaoController::class, 'mostrarLoginAdmin'])->name('admin.login');
Route::post('/admin/login', [AutenticacaoController::class, 'login'])->defaults('tipo', 'admin')->name('admin.post_login');

// Rotas de Cadastro
Route::get('/register', [AutenticacaoController::class, 'mostrarCadastro'])->name('register');
Route::post('/register/aluna', [AutenticacaoController::class, 'cadastrarAluna'])->name('cadastro.aluna');
Route::post('/register/mentora', [AutenticacaoController::class, 'cadastrarMentora'])->name('cadastro.mentora');

// Logout
Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

// Rota de Verificação de E-mail para Mentora
Route::get('/mentora/verificacao', function() {
    return view('auth.mentora_verificacao');
})->name('mentora.verificacao');
Route::post('/mentora/verificar-codigo', [AutenticacaoController::class, 'verificarCodigo'])->name('mentora.verificar_codigo');

// Dashboard Aluna (User padrão)
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('aluna.dashboard');
    })->name('dashboard');
});

// Painel Admin
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/aprovar-mentora/{id}', [AdminDashboardController::class, 'aprovar'])->name('aprovar_mentora');
    Route::post('/reprovar-mentora/{id}', [AdminDashboardController::class, 'reprovar'])->name('reprovar_mentora');
});

// Painel Mentora
Route::middleware(['auth:mentora'])->prefix('mentora')->name('mentora.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mentora.dashboard');
    })->name('dashboard');
});
