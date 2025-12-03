<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CompletarPerfil; // Importação do componente
use App\Livewire\GaleriaMentoras;
use App\Livewire\VerMentora;
use App\Livewire\MinhasSolicitacoes;
use App\Livewire\MinhasCandidaturas;
use App\Livewire\ListaEventos;
use App\Livewire\CriarEvento;

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
    Route::get('/mentoras', GaleriaMentoras::class)->name('mentoras.index');
    Route::get('/mentoras/{id}', VerMentora::class)->name('mentoras.show');
    Route::get('/minhas-solicitacoes', MinhasSolicitacoes::class)->name('solicitacoes.index');
    Route::get('/meus-pedidos', MinhasCandidaturas::class)->name('candidaturas.index');
    Route::get('/eventos', ListaEventos::class)->name('eventos.index');
    Route::get('/eventos/criar', CriarEvento::class)->name('eventos.criar');

});