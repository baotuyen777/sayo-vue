<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //đang bug ko chạy
//        return $next($request);
        dd( $request->route()->getActionName());
        if (auth()->check()) {
            // The user is logged in, so proceed to the next middleware or the route's controller.
            return $next($request);
        }
        return redirect()->route('login');
        // The user is not logged in, so return the login view.
//        return view('pages.auth.login');
    }
}
