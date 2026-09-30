<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!in_array($request->user()->user_type, $types)) {
            abort(403, 'আপনার এই পেজে প্রবেশের অনুমতি নেই।');
        }

        return $next($request);
    }
}