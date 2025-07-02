<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AgencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        if (!$user->isAgencyAdmin() && !$user->isAgencyUser() && !$user->isSuperAdmin()) {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        }

        if (!$user->isSuperAdmin() && !$user->agency) {
            return redirect('/')->with('error', 'لم يتم ربطك بأي وكالة.');
        }

        return $next($request);
    }
}
