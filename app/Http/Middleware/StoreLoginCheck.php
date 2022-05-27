<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StoreLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->exists('store-login')) {
            return redirect('store-login-form');
        }
        if(session('store-role')!='Store Owner')
        {
            return redirect('store-login-form');
        }
        return $next($request);
    }
}
