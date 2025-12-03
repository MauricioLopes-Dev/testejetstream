<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CompletarPerfil; // Importação do componente

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Qualquer um acessa)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Só logado acessa)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. O Painel Principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Sua página de completar perfil
    Route::get('/completar-perfil', CompletarPerfil::class)->name('completar-perfil');

}); // <--- O fechamento do grupo TEM que ser aqui no final!