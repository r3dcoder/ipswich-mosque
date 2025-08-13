<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
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
        //
        View::composer('*', function ($view) {
            $menus = Menu::whereNull('parent_id')->orderBy('order')->get();
            $contacts = Contact::pluck('value', 'type')->toArray();

            $view->with('headerData', [
                'logo' => '/images/logo.png', // You can also add logo to DB or config
                'menu' => $menus,
                'contact' => $contacts,
            ]);
        });
    }
}
