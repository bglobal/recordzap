<?php

namespace App\Http\Livewire\Admin\Subscription;

use App\Models\Subscription;
// use App\Models\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Stripe;

class View extends Component
{
    use LivewireAlert;
    public $subscription;
    public $status;
    public $payment_total;

    public function mount(Subscription $subscription)
    {
        if (!auth()->user()->can('admin_order_edit')) {
            return abort(403);
        }
        $this->subscription = $subscription;
    }

    public function render()
    {
        if (!auth()->user()->can('admin_subscription_create')) {
            return abort(403);
        }

        if ($this->subscription->order->meta->payment_mode == 'test') {
            $stripe_secret = config('stripe.stripe_secret_test');
        } else {
            $stripe_secret = config('stripe.stripe_secret');
        }
        $stripe = new \Stripe\StripeClient($stripe_secret);
        
        $payments =  $stripe->paymentIntents->retrieve(
            $this->subscription->stripe_payment_id,
            []
        );
        
        $subscriptions = "";
        $customers = "";

        $subscriptions = $stripe->subscriptions->retrieve(
            $this->subscription->stripe_subscription_id,
            []
        );
        // dd($subscriptions);
        $customers =  $stripe->customers->retrieve(
            $this->subscription->stripe_customer_id,
            []
        );

        return view('livewire.admin.subscription.view', compact('payments', 'subscriptions', 'customers'));
    }
}
