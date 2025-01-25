<?php

namespace App\Http\Middleware;

use App\Models\GroupUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Subscribe
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $noOfGroups = GroupUser::where('user_id', auth()->user()->id)->count();

        if ($noOfGroups >= 2 && !$request->user()?->subscribed()) {
            return redirect('/subscribe');
        }

        return $next($request);
    }
}
