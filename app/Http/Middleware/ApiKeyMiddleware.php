<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!$request->has('api_key') || $request->api_key==null || empty($request->api_key))
        {
            return response()->json(['status'=>'error','errors'=>["API KEY is required."]]);
        }
        return $next($request);
    }
}
