<div class="modal-dialog modal-xl">
    <form wire:submit.prevent="edit">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('bap.view_subscription') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('bap.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    @if (!empty($error_msg))
                    <div class="text-bg-danger p-3">{{$error_msg}}</div>
                    @else

                    @if($subscriptions)
                    <p>
                        <b>Subscription ID:</b> @if ($subscription->order->meta->payment_mode == 'test')
                        <a href="{{ config('stripe.url_test') }}subscriptions/{{$subscriptions->id}}" target="_blank">
                            @else
                            <a href="{{ config('stripe.url') }}subscriptions/{{$subscriptions->id}}" target="_blank">
                                @endif
                                {{ $subscriptions->id}}
                            </a><br>
                            <b>Created Date:</b> {{Carbon\Carbon::parse($subscriptions->created)->format("Y-m-d H:i:s")}}<br>
                            <b>Current Period Start:</b> {{Carbon\Carbon::parse($subscriptions->current_period_start)->format("Y-m-d H:i:s")}}<br>
                            <b>Current Period End:</b> {{Carbon\Carbon::parse($subscriptions->current_period_end)->format("Y-m-d H:i:s")}}<br>
                            @if ($subscriptions->canceled_at)
                            <b>Canceled Date:</b> {{Carbon\Carbon::parse($subscriptions->canceled_at)->format("Y-m-d H:i:s")}}<br>
                            @if ($subscriptions->cancellation_details->comment)
                            <b>Comment:</b> {{$subscriptions->cancellation_details->comment}}<br>
                            @endif
                            @if ($subscriptions->cancellation_details->reason)
                            <b>Reason:</b> {{$subscriptions->cancellation_details->reason}}
                            @endif
                            @endif
                    </p>
                    @endif

                    <p>
                        <a href="{{$payments->metadata->entry_url}}" target="_blank">View entry details</a>
                    </p>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('bap.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('bap.edit') }}</button>
            </div>
        </div>
    </form>
</div>