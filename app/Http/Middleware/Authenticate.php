<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }
    // app/Http/Middleware/Authenticate.php

    protected function redirectTo($request)
    {
        // Cek jika request tidak menginginkan JSON
        if (!$request->expectsJson()) {
            return url('/'); // Mengarahkan ke halaman beranda atau halaman lain
        }
    }

}