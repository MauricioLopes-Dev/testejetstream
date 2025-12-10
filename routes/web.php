<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
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
use App\Livewire\GerenciarDepoimentos;
use App\Livewire\MinhaAgenda;
use App\Livewire\GerenciarAulas;
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
| ROTA DE DIAGNÓSTICO DE E-MAIL (Temporária)
|--------------------------------------------------------------------------
| Acesse: /debug-email para ver as configurações reais e testar envio
*/
Route::get('/debug-email', function () {
    // Inicializa a variável antes para evitar erro no catch
    $info = "Iniciando diagnóstico...<br>";

    try {
        // 1. Força limpeza do cache para garantir que leu as variáveis novas
        Artisan::call('config:clear');

        $config = config('mail.mailers.smtp');
        $from = config('mail.from');
        
        // Mascara a senha para segurança
        $senhaMascarada = substr($config['password'] ?? '', 0, 3) . '...';

        // Prepara valores seguros (se não existir, mostra "NÃO DEFINIDO")
        $host = $config['host'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $port = $config['port'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $encryption = $config['encryption'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $username = $config['username'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $fromAddress = $from['address'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $fromName = $from['name'] ?? '<span style="color:red">NÃO DEFINIDO</span>';

        $info = "
        <h1>Diagnóstico de E-mail</h1>
        <h3>Configuração Carregada pelo Laravel:</h3>
        <ul>
            <li><strong>Host:</strong> {$host}</li>
            <li><strong>Porta:</strong> {$port}</li>
            <li><strong>Criptografia:</strong> {$encryption}</li>
            <li><strong>Usuário:</strong> {$username}</li>
            <li><strong>Senha:</strong> {$senhaMascarada}</li>
            <li><strong>From Address:</strong> {$fromAddress}</li>
            <li><strong>From Name:</strong> {$fromName}</li>
        </ul>
        <hr>
        <h3>Tentando enviar e-mail de teste...</h3>
        ";

        // Tenta enviar
        Mail::raw('Teste de envio Railway (Diagnóstico) 🚀', function ($msg) use ($fromAddress, $fromName) {
            $msg->to('seu.email.pessoal@gmail.com') // <--- O E-mail vai para aqui
                ->subject('Teste de Conexão - Projeto Ellas');
            
            if ($fromAddress && $fromAddress !== '<span style="color:red">NÃO DEFINIDO</span>') {
                $msg->from($fromAddress, $fromName);
            }
        });

        return $info . "<h2 style='color:green'>SUCESSO! Conexão estabelecida e e-mail enviado.</h2>";

    } catch (\Exception $e) {
        return $info . "<h2 style='color:red'>FALHA:</h2><pre>" . $e->getMessage() . "</pre>";
    }
});


/*
|--------------------------------------------------------------------------
| Rotas Públicas (Site Institucional)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home', [
        'totalUsers' => User::count(),
        'totalEvents' => Event::count(),
        'totalStories' => Story::count(),
        'testimonials' => Testimonial::where('is_active', true)->latest()->take(3)->get()
    ]); 
})->name('home');

Route::get('/sobre', function () {
    return view('pages.about');
})->name('site.about');

Route::get('/servicos', function () {
    return view('pages.services');
})->name('site.services');

Route::get('/depoimentos', function () {
    return view('pages.testimonials', [
        'testimonials' => Testimonial::where('is_active', true)->latest()->get()
    ]);
})->name('site.testimonials');


/*
|--------------------------------------------------------------------------
| Rotas de Acesso Administrativo (Portal Secreto)
|--------------------------------------------------------------------------
*/
Route::get('/portal', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/portal', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


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

    // 1. Dashboard Inteligente
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return view('dashboards.admin');
        } 
        
        if ($role === 'mentora') {
            return view('dashboards.mentora');
        }

        return view('dashboards.aluna');
    })->name('dashboard');

    // 2. Funcionalidades Gerais
    Route::get('/completar-perfil', CompletarPerfil::class)->name('completar-perfil');

    // Módulo de Mentorias
    Route::get('/mentoras', GaleriaMentoras::class)->name('mentoras.index');
    Route::get('/mentoras/{id}', VerMentora::class)->name('mentoras.show');
    Route::get('/minhas-solicitacoes', MinhasSolicitacoes::class)->name('solicitacoes.index');
    Route::get('/meus-pedidos', MinhasCandidaturas::class)->name('candidaturas.index');

    // Módulo de Eventos e Aulas
    Route::get('/eventos', ListaEventos::class)->name('eventos.index');
    Route::get('/eventos/criar', CriarEvento::class)->name('eventos.criar');
    Route::get('/minha-agenda', MinhaAgenda::class)->name('agenda.index');
    Route::get('/minhas-aulas', GerenciarAulas::class)->name('aulas.index');

    // Módulo de Blog
    Route::get('/blog', Blog::class)->name('blog.index');
    Route::get('/blog/escrever', CriarHistoria::class)->name('blog.criar');
    Route::get('/blog/{id}', LerHistoria::class)->name('blog.show');

    // 3. Área Administrativa (Protegida)
    Route::get('/admin/aprovar-mentoras', AprovarMentoras::class)->name('admin.aprovar');
    Route::get('/admin/depoimentos', GerenciarDepoimentos::class)->name('admin.depoimentos');

});