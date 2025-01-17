<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(Auth::user()){
            // if (Auth::user()->role == 2) {
            //     return redirect()->route('staff');
            // }
    
            // if (Auth::user()->role == 1) {
                return $next($request);
            // }
        }else{
            return redirect()->route('main');
        }
    }
}
