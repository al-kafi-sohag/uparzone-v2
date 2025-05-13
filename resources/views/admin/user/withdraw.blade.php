<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">User Withdrawals</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="withdrawals-table" class="table table-striped table-hover">
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
                    @foreach ($withdraws as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->id }}</td>
                            <td>{{ $withdrawal->user->name }}</td>
                            <td>{{ $withdrawal->user_transaction_id }}</td>
                            <td>{{ $withdrawal->amount }}</td>
                            <td>
                                {{ $withdrawal->gateway }}
                            </td>
                            <td>{{ $withdrawal->details }}</td>
                            <td>
                                <span class="badge {{ $withdrawal->statusBadge }}">{{ $withdrawal->statusText }}</span>
                            </td>
                            <td>{{ $withdrawal->created_at }}</td>
                            <td>
                                {{-- <a href="javascript:void(0);" data-details="{{ json_encode($payment->details) }}" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal">View</a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Update</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
