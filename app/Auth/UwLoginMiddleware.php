<?php
namespace App\Auth;

use Closure;
use Illuminate\Contracts\Container\Container;


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

        if ($user instanceof UserAnonymous) {
            
            return redirect()->away(url('/treq/saml/login/' . $request->path()) );
            // return redirect()->away('/Shibboleth.sso/Login?target=' . $request->fullUrl());
        }
        if (!hasRole('treq:user') && $request->path() != 'treq/logout' && $request->path() != 'treq/whoami') {
            
            abort(403, 'Not authorized for TREQ');
        }
        return $next($request);
    }
}
