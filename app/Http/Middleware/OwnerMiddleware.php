<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use App\Services\BulletinService;
use Closure;

class OwnerMiddleware
{
    protected $auth;

    public function __construct(Guard $auth, BulletinService $bulletinService)
    {
        $this->auth = $auth;
        $this->bulletinService = $bulletinService;
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
        $bulletinId = $request->segments()[1];
        $bulletin = $this->bulletinService->getById($bulletinId);

        if ($bulletin->user_id != $this->auth->user()->id) {
            abort(403, 'Editing is available only to the creator.');
        }

        return $next($request);
    }
}
