<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Debugbar;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::check())
        {
            $user = Auth::user();
            Debugbar::info("User role is"." ".$user->role);

           // Debugbar::info($user->password);
            if ( $user->hasRole('admin') ) {
                return redirect(route('admin_dashboard'));
            }

            // allow admin to proceed with request
            else if ( $user->hasRole('user') ) {
                return $next($request);
            }
        }
        abort(403);
    }
}
