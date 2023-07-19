<?php

namespace App\Http\Middleware;

use Closure,Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // if (! $request->user()->hasRole('Admin')) {
        //     abort(403, 'Unauthorized');
        // }

        $user = Auth::user();
        if($user) {
            if($user->role_id > 1){
                // abort(403, 'Unauthorized');
                Auth::logout();
                return redirect()->route('login')->with('auth_error', 'Unauthorized! please login with Admin Credintials.');
            }
        }
        return $next($request);
    }
}
