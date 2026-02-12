<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\AdminDashboardController;
use App\Livewire\CompletarPerfil;
use App\Livewire\GaleriaMentoras;
use App\Livewire\VerMentora;
use App\Livewire\MinhasSolicitacoes;
use App\Livewire\MinhasCandidaturas;
use App\Livewire\ListaEventos;
use App\Livewire\CriarEvento;
use App\Livewire\CriarHistoria;
use App\Livewire\GerenciarDepoimentos;
use App\Livewire\GerenciarAulas;
use App\Livewire\AprovarMentoras;
use App\Livewire\Blog;
use App\Livewire\AgendaCalendario;
use App\Livewire\MeusCursos;

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

// Rotas Protegidas para Aluna (User padrão)
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('aluna.dashboard');
    })->name('dashboard');

    // Funcionalidades Originais do Projeto
    Route::get('/completar-perfil', CompletarPerfil::class)->name('completar-perfil');
    Route::get('/mentoras', GaleriaMentoras::class)->name('mentoras.index');
    Route::get('/mentoras/{id}', VerMentora::class)->name('mentoras.show');
    Route::get('/minhas-solicitacoes', MinhasSolicitacoes::class)->name('solicitacoes.index');
    Route::get('/meus-pedidos', MinhasCandidaturas::class)->name('candidaturas.index');
    
    // Módulo de Blog/Histórias
    Route::get('/blog', Blog::class)->name('blog.index');
    
    // Módulo de Eventos e Aulas
    Route::get('/eventos', ListaEventos::class)->name('eventos.index');
    
    // Módulo de Agenda
    Route::get('/agenda', AgendaCalendario::class)->name('agenda.index');
    
    // Módulo de Cursos
    Route::get('/meus-cursos', MeusCursos::class)->name('meus.cursos');
});

// Painel Admin - Todas as funcionalidades solicitadas
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Aprovação de Mentoras
    Route::get('/mentoras-pendentes', AprovarMentoras::class)->name('mentoras.pendentes');
    Route::post('/aprovar-mentora/{id}', [AdminDashboardController::class, 'aprovar'])->name('aprovar_mentora');
    Route::post('/reprovar-mentora/{id}', [AdminDashboardController::class, 'reprovar'])->name('reprovar_mentora');

    // Gestão de Conteúdo
    Route::get('/eventos/criar', CriarEvento::class)->name('eventos.criar');
    Route::get('/aulas/gerenciar', GerenciarAulas::class)->name('aulas.gerenciar');
    Route::get('/historias/criar', CriarHistoria::class)->name('historias.criar');
    Route::get('/depoimentos', GerenciarDepoimentos::class)->name('depoimentos.gerenciar');
    
    // Perfil Admin
    Route::get('/perfil', [AdminDashboardController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/senha', [AdminDashboardController::class, 'alterarSenha'])->name('perfil.senha');
});

// Painel Mentora
Route::middleware(['auth:mentora'])->prefix('mentora')->name('mentora.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mentora.dashboard');
    })->name('dashboard');
});
