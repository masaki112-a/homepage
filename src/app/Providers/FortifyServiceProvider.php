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
use Laravel\Fortify\Fortify;

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
        // ユーザー作成アクションのカスタマイズ
        Fortify::createUsersUsing(CreateNewUser::class);
        // ユーザープロフィール情報の更新アクションのカスタマイズ
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        // ユーザーパスワードの更新アクションのカスタマイズ
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        // ユーザーパスワードのリセットアクションのカスタマイズ
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        $this->configureRateLimiting();
        
        Fortify::loginView(fn () => view('auth.login'));
        ;

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

    }

    protected function configureRateLimiting()
    {
    RateLimiter::for('login', function ($request) {
        return Limit::perMinute(5)->by($request->ip());
    });

    // 他のリミッター定があればここに追加
}
}
