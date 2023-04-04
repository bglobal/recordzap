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

    private function currency_symbol($currency)
    {
        switch (strtolower($currency)) {
            case 'usd':
                $symbol = "$";
                break;
            default:
                $symbol = "$";
        }
        return $symbol;
    }

    public function render()
    {
        if (!auth()->user()->can('admin_subscription_create')) {
            return abort(403);
        }

        $error_msg = "";
        $subscriptions = "";
        $subscriptionSchedules = "";
        $latest_invoices = "";
        $upcoming_invoices = "";
        $customers = "";
        $payments = "";
        $invoice = "";
        $phase_array = [];

        $stripe_secret = config('stripe.stripe_secret');

        $stripe = new \Stripe\StripeClient($stripe_secret);
        try {
            $payments =  $stripe->paymentIntents->retrieve(
                $this->subscription->stripe_payment_id,
                []
            );

            $subscriptions = $stripe->subscriptions->retrieve(
                $this->subscription->stripe_subscription_id,
                []
            );

            $subscriptionSchedules = $stripe->subscriptionSchedules->retrieve(
                $this->subscription->stripe_subscription_schedule_id,
                []
            );
            //Latest invoice
            $latest_invoices = $stripe->invoices->allLines($subscriptions->latest_invoice, ['limit' => 2]);

            //upcoming invoice
            $upcoming_invoices = $stripe->invoices->upcoming([
                'subscription' => $this->subscription->stripe_subscription_id,
            ]);
            if (!empty($subscriptionSchedules)) {
                foreach ($subscriptionSchedules->phases as $key => $phase) {
                    $phase_array[$key]["start_date"]    = $phase->start_date;
                    $phase_array[$key]["end_date"]    = $phase->end_date;
                    $phase_array[$key]["quantity"]    = $phase->items[0]->quantity;
                    $plans = $stripe->plans->retrieve(
                        $phase->items[0]->plan,
                        []
                    );
                    $phase_array[$key]["plan"]    = $plans->nickname;

                    $phase_array[$key]["amount"]    = $this->currency_symbol($plans->currency) . ($plans->amount) / 100;
                }
            }

            $customers =  $stripe->customers->retrieve(
                $this->subscription->stripe_customer_id,
                []
            );
        } catch (\Exception $e) {
            $error_msg = $e->getError()->message;
        }
        // dd($latest_invoices);
        return view('livewire.admin.subscription.view', compact('payments', 'subscriptions', 'phase_array', 'latest_invoices', 'upcoming_invoices', 'customers', 'error_msg'));
    }
}
