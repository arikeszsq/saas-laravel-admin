<?php

namespace App\Http\Middleware;

use Closure;

class Cross
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //允许的域名集
        $allow_origin = [
            '*',
        ];

        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';

        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN',
            'Access-Control-Expose-Headers' => 'Authorization, authenticated',
            'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, OPTIONS',
            'Access-Control-Allow-Credentials' => 'false',
        ];

        if (in_array($origin, $allow_origin)) {
            foreach($headers as $key => $value) $response->header($key, $value);
        }
        return $response;
    }
}
