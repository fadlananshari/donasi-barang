<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if(auth()->user()->role == $role){
            return $next($request);
        }

        $role = Auth::user()->role;
            
        // dd($role);
        if( $role == "donatur" ){

            return redirect('donatur');

        } elseif( $role == "penerima" ){
            
            return redirect('penerima');

        } elseif( $role == "admin" ){

            return redirect('admin');
            
        }
    }
}
