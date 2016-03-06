<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Laracasts\Flash\Flash;


class RedirectIfLowerLevel
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   $level_min : continue only if the user has a higher level than $level_min
     * @return mixed
     */
    public function handle($request, Closure $next, $level_min=2)
    {
        if ($this->auth->check()) 
        {
            if($this->auth->user()->level_id >= $level_min)
            {
                return $next($request);
            }
        }

        Flash::error('Vous n\'avez pas les droits suffisants pour ceci.');
        return redirect('/');
    }
}
