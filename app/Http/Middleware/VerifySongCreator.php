<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySongCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $target_level  restrict access when song's access level >= this level
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next, $target_level)
    {
        $song = $request->route()->parameter('song');

        if (isset($song->access_level)
            and $song->access_level >= $target_level
            and isset($song->creator_user_id)
            and $song->creator_user_id !== $request->user()->id) {
            return abort(419);
        }

        return $next($request);
    }
}
