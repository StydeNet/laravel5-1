<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    protected $hierarchy = [
        'admin'  => 3,
        'editor' => 2,
        'user'   => 1
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        if ($this->hierarchy[$user->role] < $this->hierarchy[$role]) {
            abort(404);
        }

        return $next($request);
    }
}
