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

        $group_id = $request->post('group_id');

        if ($noOfGroups >= 2 && !$request->user()?->subscribed(env('PRODUCT_NAME'))) {
//            return redirect('/subscribe/' . $group_id);
            return redirect()->route('subscribe', ['group_id' => $group_id]);
        }

        return $next($request);
    }
}
