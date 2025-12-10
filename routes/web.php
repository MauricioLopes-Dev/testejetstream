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
use App\Livewire\AprovarMentoras;
use App\Livewire\GerenciarDepoimentos; // Importação
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminLoginController;
// Models para a Home Page
use App\Models\User;
use App\Models\Event;
use App\Models\Story;
use App\Models\Testimonial;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Site Institucional Multi-páginas)
|--------------------------------------------------------------------------
*/

// Página Inicial com Dados Reais
Route::get('/', function () {
    return view('pages.home', [
        'totalUsers' => User::count(),
        'totalEvents' => Event::count(),
        'totalStories' => Story::count(),
        'testimonials' => Testimonial::where('is_active', true)->latest()->take(3)->get()
    ]); 
})->name('home');

// Página Sobre
Route::get('/sobre', function () {
    return view('pages.about');
})->name('site.about');

// Página de Serviços
Route::get('/servicos', function () {
    return view('pages.services');
})->name('site.services');

// Página de Depoimentos (Pública)
Route::get('/depoimentos', function () {
    // Também precisa enviar os depoimentos para esta página
    return view('pages.testimonials', [
        'testimonials' => Testimonial::where('is_active', true)->latest()->get()
    ]);
})->name('site.testimonials');


/*
|--------------------------------------------------------------------------
| Rotas de Administração (Controllers Customizados)
|--------------------------------------------------------------------------
*/
// Login admin
Route::get('/portal', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/portal', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Dashboard admin protegido (Middleware customizado)
//Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    //Route::get('/', function () {
       // return view('admin.dashboard'); 
    //})->name('dashboard');
//});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Sistema Principal / Jetstream)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Lógica do "Semáforo" de Dashboards
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return view('dashboards.admin');
        } 
        
        if ($role === 'mentora') {
            return view('dashboards.mentora');
        }

        // Padrão para Aluna
        return view('dashboards.aluna');
    })->name('dashboard');

    // Perfil
    Route::get('/completar-perfil', CompletarPerfil::class)->name('completar-perfil');

    // Mentoras
    Route::get('/mentoras', GaleriaMentoras::class)->name('mentoras.index');
    Route::get('/mentoras/{id}', VerMentora::class)->name('mentoras.show');

    // Solicitações e Pedidos
    Route::get('/minhas-solicitacoes', MinhasSolicitacoes::class)->name('solicitacoes.index');
    Route::get('/meus-pedidos', MinhasCandidaturas::class)->name('candidaturas.index');

    // Eventos
    Route::get('/eventos', ListaEventos::class)->name('eventos.index');
    Route::get('/eventos/criar', CriarEvento::class)->name('eventos.criar');

    // Blog
    Route::get('/blog', Blog::class)->name('blog.index');
    Route::get('/blog/escrever', CriarHistoria::class)->name('blog.criar');
    Route::get('/blog/{id}', LerHistoria::class)->name('blog.show');

    // --- ÁREA DE ADMINISTRAÇÃO (Livewire) ---
    Route::get('/admin/aprovar-mentoras', AprovarMentoras::class)->name('admin.aprovar');
    Route::get('/admin/depoimentos', GerenciarDepoimentos::class)->name('admin.depoimentos');

});