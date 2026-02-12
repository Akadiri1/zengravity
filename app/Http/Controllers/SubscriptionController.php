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

        if (!$priceId) {
            abort(500, "Stripe Price ID for '{$plan}' is not configured in your .env file.");
        }

        return $request->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('app'),
                'cancel_url' => route('subscription.pricing'),
            ]);
    }

    public function portal(Request $request)
    {
        \Illuminate\Support\Facades\Log::info("User {$request->user()->id} requesting billing portal.");
        return $request->user()->redirectToBillingPortal(route('app'));
    }

    public function sync(Request $request)
    {
        $user = $request->user();
        
        try {
            // Ensure the user has a Stripe ID
            if (!$user->stripe_id) {
                $user->createOrGetStripeCustomer();
            }
            
            // Get a direct Stripe client using the Cashier secret
            $stripe = new \Stripe\StripeClient(config('cashier.secret') ?? config('services.stripe.secret'));
            
            // Fetch all subscriptions for this customer directly from the Stripe API
            $stripeSubscriptions = $stripe->subscriptions->all(['customer' => $user->stripe_id]);
            
            if (count($stripeSubscriptions->data) > 0) {
                foreach ($stripeSubscriptions->data as $stripeSubscription) {
                    $planId = $stripeSubscription->items->data[0]->price->id;
                    
                    // Manually sync to local database
                    $user->subscriptions()->updateOrCreate(
                        ['stripe_id' => $stripeSubscription->id],
                        [
                            'type' => 'default',
                            'stripe_status' => $stripeSubscription->status,
                            'stripe_price' => $planId,
                            'quantity' => $stripeSubscription->quantity,
                            'trial_ends_at' => $stripeSubscription->trial_end ? \Carbon\Carbon::createFromTimestamp($stripeSubscription->trial_end) : null,
                            'ends_at' => null,
                        ]
                    );
                    
                    \Illuminate\Support\Facades\Log::info("Synced subscription: {$stripeSubscription->id} status: {$stripeSubscription->status} for User: {$user->id}");
                }
                
                return redirect()->route('app')->with('status', 'Subscription synced successfully! You are now PRO.');
            }
            
            \Illuminate\Support\Facades\Log::warning("Manual sync: No active subscriptions found on Stripe for User: {$user->id}");
            return redirect()->route('app')->with('error', 'Stripe says you have no active subscriptions. If you just paid, please wait 30 seconds and try again.');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Manual sync failed: " . $e->getMessage());
            return redirect()->route('app')->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }
}
