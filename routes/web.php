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
use App\Livewire\GerenciarAulas;
use App\Livewire\AgendaCalendario; // <--- Substitui MinhaAgenda
use App\Livewire\MeusCursos;       // <--- Novo componente
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
| ROTA DE DIAGNÓSTICO DE E-MAIL (AVANÇADA)
|--------------------------------------------------------------------------
| Acesse: /debug-email para ver as configurações reais e testar envio
*/
Route::get('/debug-email', function () {
    set_time_limit(120);
    $info = "<h1>Diagnóstico de E-mail (Resend/SMTP)</h1>";

    try {
        Artisan::call('config:clear');
        $info .= "<p style='color:green'>✔ Cache de configuração limpo.</p>";

        $config = config('mail.mailers.smtp');
        $from = config('mail.from');
        
        $host = $config['host'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $port = $config['port'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $encryption = $config['encryption'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $username = $config['username'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $passwordRaw = $config['password'] ?? '';
        $senhaMascarada = substr($passwordRaw, 0, 4) . '...' . substr($passwordRaw, -4);
        $fromAddress = $from['address'] ?? '<span style="color:red">NÃO DEFINIDO</span>';
        $fromName = $from['name'] ?? '<span style="color:red">NÃO DEFINIDO</span>';

        $info .= "
        <h3>Configuração Ativa:</h3>
        <ul>
            <li><strong>Host:</strong> {$host}</li>
            <li><strong>Porta:</strong> {$port} <small>(Recomendado: 2525)</small></li>
            <li><strong>Criptografia:</strong> {$encryption} <small>(Deve ser 'tls')</small></li>
            <li><strong>Usuário:</strong> {$username}</li>
            <li><strong>Senha:</strong> {$senhaMascarada}</li>
            <li><strong>From:</strong> {$fromAddress} ({$fromName})</li>
        </ul>
        <hr>
        <h3>Tentando enviar e-mail... (Aguarde)</h3>
        ";

        Mail::raw('Teste de envio Railway com Timeout Aumentado 🚀', function ($msg) use ($fromAddress, $fromName) {
            $msg->to('seu.email.pessoal@gmail.com') // <--- SEU EMAIL AQUI
                ->subject('Teste de Conexão - Projeto Ellas');
            
            if ($fromAddress && $fromAddress !== '<span style="color:red">NÃO DEFINIDO</span>') {
                $msg->from($fromAddress, $fromName);
            }
        });

        return $info . "<h2 style='color:green'>SUCESSO! E-mail enviado.</h2>";

    } catch (\Throwable $e) {
        return $info . "<h2 style='color:red'>FALHA:</h2>
        <p><strong>Erro:</strong> " . $e->getMessage() . "</p>
        <p><strong>Arquivo:</strong> " . $e->getFile() . " (Linha " . $e->getLine() . ")</p>
        <pre style='background:#eee;padding:10px;'>" . $e->getTraceAsString() . "</pre>";
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
    
    // AGENDA ATUALIZADA (Separamos MinhaAgenda em Calendário e Cursos)
    Route::get('/minha-agenda', AgendaCalendario::class)->name('agenda.index');
    Route::get('/meus-cursos', MeusCursos::class)->name('meus.cursos');
    
    // Módulo de Gestão de Aulas (Mentora)
    Route::get('/minhas-aulas', GerenciarAulas::class)->name('aulas.index');

    // Módulo de Blog
    Route::get('/blog', Blog::class)->name('blog.index');
    Route::get('/blog/escrever', CriarHistoria::class)->name('blog.criar');
    Route::get('/blog/{id}', LerHistoria::class)->name('blog.show');

    // 3. Área Administrativa (Protegida)
    Route::get('/admin/aprovar-mentoras', AprovarMentoras::class)->name('admin.aprovar');
    Route::get('/admin/depoimentos', GerenciarDepoimentos::class)->name('admin.depoimentos');
    
    // Redirecionamento para corrigir links antigos de e-mail
    Route::get('/teste-email', function () {
        return redirect('/debug-email');
    });

    // Rota Temporária para virar Admin (APAGUE DEPOIS DE USAR)
    Route::get('/tornar-admin/{email}', function ($email) {
        $user = App\Models\User::where('email', $email)->first();
        if (!$user) return "Usuário não encontrado.";
        
        $user->update(['role' => 'admin', 'email_verified_at' => now()]);
        
        if (!$user->personalTeam()) {
            $team = \App\Models\Team::forceCreate([
                'user_id' => $user->id, 
                'name' => explode(' ', $user->name, 2)[0]."'s Team", 
                'personal_team' => true
            ]);
            $user->forceFill(['current_team_id' => $team->id])->save();
        }
        return "Sucesso! {$email} agora é Admin.";
    });

});