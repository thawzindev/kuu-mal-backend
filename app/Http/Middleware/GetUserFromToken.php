<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Contracts\Events\Dispatcher;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class GetUserFromToken
{
    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory  $response
     * @param \Illuminate\Contracts\Events\Dispatcher  $events
     * @param \Tymon\JWTAuth\JWTAuth  $auth
     */
    public function __construct(Dispatcher $events, JWTAuth $auth)
    {
        $this->events = $events;
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
        try {
            $user = \JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response(['error' => 'Token expired'], 401);
        } catch (JWTException $e) {
            return response(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
