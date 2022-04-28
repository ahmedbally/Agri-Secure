<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;

class TrustSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasSession() || ! $request->user()) {
            return $next($request);
        }

        if (! $request->session()->has('trust_session_'.$this->auth->getDefaultDriver())) {
            $this->storeSessionData($request);
        }

        if ($request->session()->get('trust_session_'.$this->auth->getDefaultDriver()) !== $this->sessionData($request)) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            if (! is_null($this->guard()->user())) {
                $this->storeSessionData($request);
            }
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function storeSessionData($request)
    {
        if (! $request->user()) {
            return;
        }

        $request->session()->put([
            'trust_session_'.$this->auth->getDefaultDriver() => $this->sessionData($request),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        throw new AuthenticationException('Unauthenticated.', [$this->auth->getDefaultDriver()]);
    }


    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return $this->auth;
    }

    /**
     * Data to be stored
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function sessionData($request)
    {
        return sha1($request->userAgent().'|'.$request->ip());
    }
}
