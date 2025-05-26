<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\usermodel; // Ensure this import is here for user validation

class AccountAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     **/
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('userid') || !usermodel::find($request->session()->get('userid'))) {
            return redirect()->route('pages.userlogin')->with('error', 'Please log in first.');
        }
        
        return $next($request);
    }
}
