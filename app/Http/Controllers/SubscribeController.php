<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SubscribeController extends Controller
{
//    /**
//     * Cashier's newSubscription() method of the user sends the user's and product's info to
//     * Stripe Checkout, Checkout sends back a secure payment form, the user fills out that form
//     * with their payment and personal information, submits it to Stripe, Stripe creates
//     * a new customer and a new subscription, and sends the user/flow onto the success url
//     */
//    public function subscribe(Request $request)
//    {
//        return $request->user()
//            ->newSubscription(env('PRODUCT_NAME'), env('PROD_ID'))
//            ->checkout([
//                'success_url' => route('success'),
//                'cancel_url' => route('cancel'),
//            ]);
//    }

    /**
     * User needs to fill out the Stripe Checkout form and create Stripe customer and subscription
     * They got here because they were creating (and joining) a third, non-free group
     */
    public function subscribeCreateGroup(Request $request)
    {
        return Auth::user()
            ->newSubscription(env('PRODUCT_NAME'), env('PROD_ID'))
            ->checkout([
                'success_url' => route('successCreateGroup'),
                'cancel_url' => route('cancel'),
            ]);
    }

    /**
     * User needs to fill out the Stripe Checkout form and create Stripe customer and subscription
     * They got here because they were joining a third, non-free group
     */
    public function subscribeJoinGroup(Request $request)
    {
        return Auth::user()
            ->newSubscription(env('PRODUCT_NAME'), env('PROD_ID'))
            ->checkout([
                'success_url' => route('successJoinGroup'),
                'cancel_url' => route('cancel'),
            ]);
    }

    /**
     * Stripe successfully processed user's payment info and created a new Stripe customer
     * and subscription.  Now create group and send user on that route
     */
    public function successCreateGroup(Request $request): RedirectResponse
    {
        $formInput = $request->session()->get('validated');

        $group = new Group();
        $group->name = $formInput['name'];
        $group->description = $formInput['description'];
        $group->location_id = $formInput['location_id'];
        $group->creator_id = auth()->user()->id;
        $group->save();

        Auth::user()->groups()->attach($group, ['role'=>UserRoleEnum::ADMIN]);

        // not increasing subscription quantity by 1 because that happened when subscription created

        return redirect( route('groups.show', ['group' => $group]) );
    }

    /**
     * Stripe successfully processed user's payment info and created a new Stripe customer
     * and subscription. Now add user to that group and send user on that route
     */
    public function successJoinGroup(Request $request): RedirectResponse
    {
        $formInput = $request->session()->get('validated');

        $group_id = $formInput['group_id'];

        // not increasing subscription quantity by 1 because that happened when subscription created

        Auth::user()->groups()->attach($group_id, ['role' => UserRoleEnum::MEMBER]);

        return redirect(route('groups.show', ['group' => $group_id]));
    }

    /**
     * User cancelled filling out the Stripe Checkout form
     */
    public function cancel(): View
    {
        return view('subscribe.subscribe-cancel');
    }
}
