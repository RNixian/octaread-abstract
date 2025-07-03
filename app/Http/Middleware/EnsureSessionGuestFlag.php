<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSessionGuestFlag
{
 public function handle(Request $request, Closure $next)
{
    if (!Auth::guard('web')->check()) {
        return redirect()->route('pages.userlogin')->with('error', 'Please log in first.');
    }

    $user = Auth::guard('web')->user();

    if (!session()->has('is_guest')) {
        session(['is_guest' => str_starts_with($user->schoolid, 'guest')]);
    }

    return $next($request);
}

}

