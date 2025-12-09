<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CompletarPerfil;
use App\Livewire\GaleriaMentoras;
use App\Livewire\VerMentora;
use App\Livewire\MinhasSolicitacoes;
use App\Livewire\MinhasCandidaturas;
use App\Livewire\ListaEventos;
use App\Livewire\CriarEvento;
use App\Livewire\CriarHistoria;
use App\Livewire\Blog;
use App\Livewire\LerHistoria;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminLoginController;


/*
|--------------------------------------------------------------------------
| Rota Pública
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rotas de Administração (Apenas Admins)
|--------------------------------------------------------------------------
*/
// Login admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Dashboard admin protegido
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard'); // Blade admin
    })->name('dashboard');
});
/*
|--------------------------------------------------------------------------
| Rotas Protegidas (usuário logado e verificado)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/completar-perfil', CompletarPerfil::class)->name('completar-perfil');

    Route::get('/mentoras', GaleriaMentoras::class)->name('mentoras.index');
    Route::get('/mentoras/{id}', VerMentora::class)->name('mentoras.show');

    Route::get('/minhas-solicitacoes', MinhasSolicitacoes::class)->name('solicitacoes.index');
    Route::get('/meus-pedidos', MinhasCandidaturas::class)->name('candidaturas.index');

    Route::get('/eventos', ListaEventos::class)->name('eventos.index');
    Route::get('/eventos/criar', CriarEvento::class)->name('eventos.criar');

    Route::get('/blog', Blog::class)->name('blog.index');
    Route::get('/blog/escrever', CriarHistoria::class)->name('blog.criar');

    Route::get('/blog/{id}', LerHistoria::class)->name('blog.show');

});
