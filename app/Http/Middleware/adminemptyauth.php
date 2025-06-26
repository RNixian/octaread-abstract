<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\adminmodel;

class adminemptyauth
{
     public function handle(Request $request, Closure $next)
    {
        // ✅ Allow access if no admins exist
        if (adminmodel::count() === 0) {
            return $next($request);
        }

        // ✅ If user is already logged in as admin, allow access
        if ($request->session()->has('adminid') && adminmodel::find($request->session()->get('adminid'))) {
            return $next($request);
        }

        // ❌ Otherwise, redirect to login
        return redirect()->route('admin.adminlogin');
    }
}

