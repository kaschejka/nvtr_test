<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\User;

class event
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
if ($request->user()) {
  if ($request->user()->role == 'admin') {
    return $next($request);
  } else {
    if (strstr($request->url(), 'events/create') || strstr($request->url(), 'edit')) {
       return redirect('/');
    } else {
      return $next($request);
    }
  }
} else {
  if (strstr($request->url(), 'events/create') || strstr($request->url(), 'edit')) {
     return redirect('/');
  } else {
    return $next($request);
  }
}

    }
}
