<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CreateSlug
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
        $user = $request->user();
        $slug = $request['group_name'] . '_' . $request->user()->id;
        $request['slug'] = $slug;
        
        return $next($request);
    }
}
