<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->singleton(\Kreait\Firebase\Auth::class, function ($app) {
        //     // Menggunakan FirebaseFactory untuk membuat objek Auth
        //     $firebase = (new Factory)->withServiceAccount((base_path(env('FIREBASE_CREDENTIALS'))));
        //     return $firebase->createAuth();
        // });
    }

    public function boot()
    {
        // Boot logic jika diperlukan
    }
}
