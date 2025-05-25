<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Profile;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Inyección de variables automáticamente a las vistas
        // View::composer(['personas.*'], function ($view) {
        // $user = auth('user')->user();
        //     if ($user && $user->profile) {
        //         $perfil = $user->profile->load('profilePhoto');
        //         $view->with('perfil', $perfil);
        //     }
        // });

        // View::composer(['restaurantes.*'], function ($view) {
        // $restaurant = auth('restaurant')->user();
        //     if ($restaurant && $restaurant->profile) {
        //         $perfilRestaurante = $restaurant->profile->load('profilePhoto');
        //         $view->with('perfil', $perfilRestaurante);
        //     }
        // });
    }
}
