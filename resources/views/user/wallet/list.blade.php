@extends('user.layout.master')

@section('title', 'Withdrawal History')

@section('content')
<div class="container px-4 py-6 mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Withdrawal History</h1>
        <p class="text-gray-600">View all your withdrawal requests</p>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        @if($withdraws->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Amount</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Gateway</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Account</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Division</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($withdraws as $withdraw)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $withdraw->created_at->format('d M, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $withdraw->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($withdraw->amount, 2) }} tk
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $withdraw->gateway }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $withdraw->account_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $withdraw->division }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = 'text-yellow-800 bg-yellow-100';
                                        $statusText = 'Pending';
                                        
                                        if ($withdraw->status == \App\Models\UserWithdraw::STATUS_APPROVED) {
                                            $statusClass = 'text-green-800 bg-green-100';
                                            $statusText = 'Approved';
                                        } elseif ($withdraw->status == \App\Models\UserWithdraw::STATUS_REJECTED) {
                                            $statusClass = 'text-red-800 bg-red-100';
                                            $statusText = 'Rejected';
                                        }
                                    @endphp
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 {{ $statusClass }} rounded-full">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($withdraw->details)
                                        <div class="text-sm text-gray-900 max-w-xs truncate">{{ $withdraw->details }}</div>
                                    @else
                                        <div class="text-sm text-gray-500">No details</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $withdraws->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No withdrawals</h3>
                <p class="mt-1 text-sm text-gray-500">You don't have any withdrawal requests yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection