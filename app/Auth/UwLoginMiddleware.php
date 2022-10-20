<?php
namespace App\Auth;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Log;

class UwLoginMiddleware
{
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->app['user'];

        Log::debug('Info about User');

        if ($user instanceof UserAnonymous) {
            Log::debug('Redirecting user to SAML');
            return redirect()->away(url('/treq/saml/login/' . urlencode($request->path())) );
            // return redirect()->away('/Shibboleth.sso/Login?target=' . $request->fullUrl());
        }
        if (!hasRole('treq:user') && $request->path() != 'treq/logout' && $request->path() != 'treq/whoami') {
            Log::debug('No suitable Role for user');
            abort(403, 'Not authorized for TREQ');
        }
        return $next($request);
    }
}
