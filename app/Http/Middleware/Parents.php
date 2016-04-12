<?php

namespace Jcfk\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Jcfk\Models\User;

class Parents
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $this->auth->user();

        if ($this->auth->guest() || !$user->parent()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('homepage'));
            }
        }

        return $next($request);
    }
}
