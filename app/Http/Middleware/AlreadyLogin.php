<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use App\Models\Agent;
use Illuminate\Http\Request;

class AlreadyLogin
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
        if(Session::has('AdminId') && url('Admin')==$request->url()){
            return redirect('Admin/Dashbord')->with('danger','Vous êtes déjà connecté');
        }
      
        return $next($request);
    }
}
