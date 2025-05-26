<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\adminmodel; 
class adminauth
{
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     **/
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('adminid') || !adminmodel::find($request->session()->get('adminid'))) {
            return redirect()->route('admin.adminlogin')->with('error', 'Please log in first.');
        }
        
        return $next($request);
    }
}
