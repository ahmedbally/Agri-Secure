<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrustReferer
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
        $host = $request->getHost();
        $referrer = $request->headers->get('referer');

        if (is_string($referrer) && false === $this->validateDomain($host, $referrer)) {
            $request->headers->remove('referer');
        }

        return $next($request);
    }

    protected function validateDomain(string $host, string $referrer): bool
    {
        $referrerHost = parse_url($referrer, PHP_URL_HOST);
        return $host === $referrerHost;
    }
}
