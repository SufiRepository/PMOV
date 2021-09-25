<?php

namespace App\Http\Middleware;

use Closure;

class access_level_3
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role == 2) {
            return redirect()->route('access_level_2');
        }

        if (Auth::user()->role == 3) {
            return redirect()->route('access_level_3');
        }

        if (Auth::user()->role == 4) {
            return redirect()->route('access_level_4');
        }

    }
}
