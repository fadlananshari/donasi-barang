<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {

                $role = Auth::user()->role;

                if( $role == "donatur" ){

                    return redirect('donatur');
    
                } elseif( $role == "penerima" ){
                    
                    return redirect('penerima');
                    
                } elseif( $role == "admin" ){
    
                    return redirect('admin');
                    
                }
            }            
        }

        return $next($request);
    }
}
