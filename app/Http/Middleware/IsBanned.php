<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class isBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::findOrFail(Auth::user()->id);
        if(!$user->isBanned()){
            session()->flash('user-banned', 'You currently do not have access to KSU Today');
            Auth::logout();
            return redirect()->intended('/');
        }
        
        return $next($request);
    }
}
