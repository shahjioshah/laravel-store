<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Debugbar;

class AdminMiddleware
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
           Debugbar::info("Admin role is"." ".$user->role);
            if ( $user->hasRole('user') ) {
                return redirect(route('dashboard'));
            }

            // allow admin to proceed with request
            else if ( $user->hasRole('admin') ) {
                return $next($request);
            }
        }
        abort(403);
    }
}
