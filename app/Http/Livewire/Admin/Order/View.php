<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Stripe;

class View extends Component
{
    use LivewireAlert;
    public $order;
    public $status;
    public $payment_total;

    public function mount(Order $order)
    {
        if (!auth()->user()->can('admin_order_edit')) {
            return abort(403);
        }
        $this->order = $order;
    }

    public function render()
    {
        if (!auth()->user()->can('admin_payment_view')) {
            return abort(403);
        }
        
        if ($this->order->meta->payment_mode == 'test') {
            $stripe_secret = config('stripe.stripe_secret_test');
        } else {
            $stripe_secret = config('stripe.stripe_secret');
        }

        $stripe = new \Stripe\StripeClient($stripe_secret);

        $payments =  $stripe->paymentIntents->retrieve(
            $this->order->meta->payment_transaction,
            []
        );
        //dd($payments);
        $subscriptions = "";
        $customers = "";
        if (!empty($this->order->meta->payment_subscription) || $this->order->meta->payment_subscription != "") {

            $subscriptions = $stripe->subscriptions->retrieve(
                $this->order->meta->payment_subscription,
                []
            );
            $customers =  $stripe->customers->retrieve(
                $this->order->meta->payment_customer,
                []
            );
        }
        return view('livewire.admin.order.view', compact('payments', 'subscriptions', 'customers'));
    }
}
