<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">User Payments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="payments-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Payment Method') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->user->name }}</td>
                            <td>{{ $payment->user_transaction_id }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>
                                <span class="badge {{ $payment->payment_method == App\Models\UserPayment::PAYMENT_METHOD_SSLCOMMERZ ? 'bg-success' : 'bg-danger' }}">{{ $payment->payment_method == App\Models\UserPayment::PAYMENT_METHOD_SSLCOMMERZ ? __('SSLCommerz') : __('Manual') }}</span>
                            </td>
                            <td>{{ $payment->payment_note }}</td>
                            <td>
                                <span class="badge {{ $payment->status == App\Models\UserPayment::STATUS_COMPLETED ? 'bg-success' : 'bg-danger' }}">{{ $payment->status == App\Models\UserPayment::STATUS_COMPLETED ? __('Completed') : __('Pending') }}</span>
                            </td>
                            <td>{{ $payment->created_at }}</td>
                            <td>
                                {{-- <a href="javascript:void(0);" data-details="{{ json_encode($payment->details) }}" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal">View</a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Update</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Payment Details</h5>
                        <p id="payment-details"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
