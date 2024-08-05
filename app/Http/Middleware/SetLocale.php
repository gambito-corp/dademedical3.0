<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
//    public function handle(Request $request, Closure $next)
//    {
//        $app = app()->getLocale();
//        $session = session('locale');
//        $locale = $session ? $session : $app;
//        if ($session == null) {
//            Session::put('locale', $locale);
//        }
//        App::setLocale($locale);
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next)
    {
        // Verificar si hay un parámetro de idioma en la URL
        if ($request->has('locale')) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        }

        // Si no hay parámetro en la URL, usar el valor almacenado en la sesión
        $locale = Session::get('locale', config('app.locale'));

        // Establecer el idioma de la aplicación
        App::setLocale($locale);

        return $next($request);
    }
}
