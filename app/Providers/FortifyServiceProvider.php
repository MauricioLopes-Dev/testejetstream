<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

         // --- LÓGICA NOVA PARA BLOQUEAR ADMIN NO LOGIN COMUM ---
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
	
            // 1. Verifica se usuário existe e senha está certa
            if ($user && Hash::check($request->password, $user->password)) {
                
                // 2. Bloqueia se for Admin (regra existente)
                if ($user->role === 'admin') {
                    return null;
                }

                // 3. Bloqueia se o e-mail não estiver verificado
                // Isso impede o login até que o código de 6 dígitos seja validado
                if (!$user->hasVerifiedEmail()) {
                    return null;
                }
	
                // Se passou em tudo, permite o login
                return $user;
            }
        });

    }
}
