<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ __('bap.payment_details') }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('bap.close') }}"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                @if (!empty($error_msg))
                <div class="text-bg-danger p-3">{{$error_msg}}</div>
                @else


                <p><b>Payment Date:</b> {{$order->date}}<br />
                    <b>Payment Mode:</b> {{$order->meta->payment_mode}}<br />
                    <b>Payment Status:</b> {{$order->status}}<br>
                    <b>Payment ID:</b>
                    @if (!empty($order->meta->payment_mode) && $order->meta->payment_mode == 'test')
                    <a href="{{ config('stripe.url_test') }}payments/{{$order->meta->payment_transaction}}" target="_blank">
                        @else
                        <a href="{{ config('stripe.url') }}payments/{{$order->meta->payment_transaction}}" target="_blank">
                            @endif
                            {{$order->meta->payment_transaction}}
                        </a><br>

                        <b>Payment Total:</b>
                        @if($order->meta)
                        @switch(strtolower($order->meta->payment_currency))
                        @case('usd')
                        $
                        @break

                        @default
                        $
                        @endswitch
                        {{ $order->meta->payment_total }}
                        @endif
                        <br />

                        <b>Customer Email:</b>
                        @if ($payments->receipt_email)
                        {{$payments->receipt_email}}
                        @else
                        {{$customers->email}}
                        @endif<br />
                        @if ($payments->description)
                        <b> Description:</> {{$payments->description}}<br />
                            @endif

                </p>
                <p>
                    <a href="{{$payments->metadata->entry_url}}" target="_blank">View entry details</a>


                </p>
                @endif
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('bap.close') }}</button>
        </div>
    </div>
</div>