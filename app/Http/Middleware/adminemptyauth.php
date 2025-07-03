<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\adminmodel;

class adminemptyauth
{
    public function handle(Request $request, Closure $next)
    {
        if (adminmodel::count() === 0) {
            return $next($request); // allow register if no admins exist
        }

        if (Auth::guard('admin')->check()) {
            return $next($request); // allow if logged in
        }

        return redirect()->route('admin.adminlogin'); // else block
    }
}
