<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription.pricing');
    }

    public function checkout(Request $request, $plan)
    {
        $priceId = match ($plan) {
            'pro-monthly' => config('services.stripe.pro_monthly_id'),
            'pro-yearly' => config('services.stripe.pro_yearly_id'),
            'team-monthly' => config('services.stripe.team_monthly_id'),
            'team-yearly' => config('services.stripe.team_yearly_id'),
            default => abort(404),
        };

        return $request->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('app'),
                'cancel_url' => route('subscription.pricing'),
            ]);
    }

    public function portal(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('app'));
    }
}
