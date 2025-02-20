<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    // protected $except = [
    //     'api/v1/users/register'
    // ];

    // protected $except = [
    //     'v1/login',  // Sesuaikan dengan route login di API
    //     'v1/users/register' // Jika pendaftaran user juga mengalami masalah
    // ];

    protected $except = [
        'login', // Menonaktifkan CSRF untuk login
        'users/register',
        'users/update/*',
        'users/delete/*',
        'roles/create',
        'roles/update/*',
        'roles/delete/*'
    ];

    // protected $except = [
    //     'login', // ✅ Pastikan API login tidak dicek CSRF
    //     'logout',
    //     'api/*' // ✅ Semua route API juga dikecualikan
    // ];

}
