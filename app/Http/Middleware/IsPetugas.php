<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPetugas
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'pustakawan') {
                return $next($request);
            } elseif ($user->role == 'admin') {
                return redirect()->route('adminDashboard')->with('msg', ['type' => 'danger', 'message' => 'Anda Bukan Petugas!']);
            } elseif ($user->is_active == 'nonaktif') {
                return redirect()->route('login')->with('msg', ['type' => 'danger', 'message' => 'Silahkan Login Terlebih Dahulu!']);
            } else {
                return redirect()->route('home')->with('msg', ['type' => 'danger', 'message' => 'Anda Bukan Petugas!']);
            }
        }
        return redirect()->route('login')->with('msg', ['type' => 'danger', 'message' => 'Silahkan Login Terlebih Dahulu!']);
    }
}
