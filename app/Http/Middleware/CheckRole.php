<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckRole
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

        

        if(!Auth::check()){
            return redirect()->intended('/logout-user');
        } else{
            //-- Log the user's login time
            $user = User::findOrFail(Auth::user()->id);
            $user->last_login = Carbon::now();
            $user->save();
            if($user->isUser()){
                return redirect()->intended('/home-page');
            }
            elseif($user->isContributor()){
                return redirect()->intended('/home-page');
            }
            elseif($user->isModerator()){
                return redirect()->intended('/home-page');
            }
            elseif($user->isAdmin()){
                return redirect()->intended('/home-page');
            }
            elseif($user->isInactive()){
                // session()->flash('user-inactive', 'You currently do not have access to KSU Today');
                return redirect()->intended('/inactive-user');
            }
        }

        // if($user->isUser()){
        //     return redirect()->intended('/user');
        // }
        // if($user->isContributor()){
        //     return redirect()->intended('/contributor');
        // }
        // if($user->isModerator()){
        //     return redirect()->intended('/moderator');
        // }
        // if($user->isAdmin()){
        //     return redirect()->intended('/admin');
        // }
        // if($user->isInactive()){
        //     session()->flash('user-inactive', 'You currently do not have access to KSU Today');
        //     Auth::logout();
        //     return redirect()->intended('/');
        // }


        return $next($request);



    }
}
