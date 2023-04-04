<div class="modal-dialog modal-xl">
    
        <div class="modal-content">
            <div class="modal-header">
                <h1>{{ __('bap.subscription_details') }}</h1>
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
                            <b>Created Date:</b> {{Carbon\Carbon::parse($subscriptions->created)->format("M d, Y")}}<br>
                            <b>Current Period Start:</b> {{Carbon\Carbon::parse($subscriptions->current_period_start)->format("M d, Y")}}<br>
                            <b>Current Period End:</b> {{Carbon\Carbon::parse($subscriptions->current_period_end)->format("M d, Y")}}<br>
                            @if ($subscriptions->canceled_at)
                            <b>Canceled Date:</b> {{Carbon\Carbon::parse($subscriptions->canceled_at)->format("M d, Y")}}<br>
                            @if ($subscriptions->cancellation_details->comment)
                            <b>Comment:</b> {{$subscriptions->cancellation_details->comment}}<br>
                            @endif
                            @if ($subscriptions->cancellation_details->reason)
                            <b>Reason:</b> {{$subscriptions->cancellation_details->reason}}
                            @endif
                            @endif
                    </p>
                    @endif
                    <h2>Subscription phase details</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Plan</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($phase_array as $phase)
                            <tr>
                                <td>{{Carbon\Carbon::parse($phase["start_date"])->format("M d, Y")}}</td>
                                <td>{{Carbon\Carbon::parse($phase["end_date"])->format("M d, Y")}}</td>
                                <td>{{$phase["plan"]}}</td>
                                <td>{{$phase["quantity"]}}</td>
                                <td>{{$phase["amount"]}}/Monthly</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h2>Latest invoice</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latest_invoices->data as $invoice)
                            <tr>
                                <td>{{Carbon\Carbon::parse($invoice->period->start)->format("M d, Y")}} - {{Carbon\Carbon::parse($invoice->period->end)->format("M d, Y")}}
                                    <p>{{$invoice->plan->nickname}}</p>
                                </td>
                                <td>{{$invoice->quantity}}</td>
                                <td>${{$invoice->amount/100}}/Monthly</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h2>Upcoming invoice</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($upcoming_invoices->lines->data as $invoice)
                            <tr>
                                <td>{{Carbon\Carbon::parse($invoice->period->start)->format("M d, Y")}} - {{Carbon\Carbon::parse($invoice->period->end)->format("M d, Y")}}
                                    <p>{{$invoice->plan->nickname}}</p>
                                </td>
                                <td>{{$invoice->quantity}}</td>
                                <td>${{$invoice->amount/100}}/Monthly</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>
                        <a href="{{$payments->metadata->entry_url}}" target="_blank">View entry details</a>
                    </p>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('bap.close') }}</button>
                <!-- <button type="submit" class="btn btn-primary">{{ __('bap.edit') }}</button> -->
            </div>
        </div>
    
</div>