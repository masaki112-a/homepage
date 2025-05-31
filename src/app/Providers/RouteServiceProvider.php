<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * このサービスプロバイダでルートの登録に使うパス
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * ルートバインディング、パターンフィルターなどの設定
     */
    public function boot(): void
    {
        parent::boot();

        // 必要に応じてルートバインディングやパターンを追加する
    }

    /**
     * ルートの登録
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapFortifyRoutes();
    }

    /**
     * web.php のルーティング
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * api.php のルーティング
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    /**
     * fortify.php のルーティング
     */
    protected function mapFortifyRoutes(): void
    {
        if (file_exists(base_path('routes/fortify.php'))) {
            Route::middleware('web')
                ->group(base_path('routes/fortify.php'));
        }
    }
}
