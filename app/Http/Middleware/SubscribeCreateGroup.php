<?php

namespace App\Http\Middleware;

use App\Models\GroupUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeCreateGroup
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // unusual to have validation in middleware and not before save in Group controller
        // but if Laravel validation fails, it naturally/automatically sends user back to
        // previous page/form and that makes sense here, doesn't work after Stripe Checkout page
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_name' => 'required|string',
            'location_id' => 'required|integer',
        ]);

        // we lose Request object while going through Stripe Checkout, so adding vars to session
        // to have access to and be able to add to database at the end
        $request->session()->put('validated', $validated);

        $noOfGroups = GroupUser::where('user_id', auth()->user()->id)->count();

        // have they used all of their free group memberships and are they not a subscriber
        // who's provided payment information?  Redirect to Stripe Checkout form if yes
        if ($noOfGroups >= 2 && !$request->user()?->subscribed(env('PROD_ID'))) {
            return redirect('/subscribeCreateGroup');
        }

        return $next($request);
    }
}
