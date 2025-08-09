<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider

 public function boot(): void
{
    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api') // <--- এই লাইনটি খুবই গুরুত্বপূর্ণ
            ->group(base_path('routes/api.php')); // <--- এবং এই লাইনটিও

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}