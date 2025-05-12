@extends('user.layout.master')

@section('title', 'Transaction History')

@section('content')
<div class="container px-4 py-6 mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Transaction History</h1>
        <p class="text-gray-600">View all your transaction records</p>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Amount</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Note</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">From/To</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $transaction->created_at->format('d M, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 {{ $transaction->type == \App\Models\UserTransaction::TYPE_CREDIT ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }} rounded-full">
                                        {{ $transaction->typeText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium {{ $transaction->type == \App\Models\UserTransaction::TYPE_CREDIT ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == \App\Models\UserTransaction::TYPE_CREDIT ? '+' : '-' }} {{ number_format($transaction->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $transaction->note }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 {{ $transaction->status == \App\Models\UserTransaction::STATUS_COMPLETED ? 'text-green-800 bg-green-100' : 'text-yellow-800 bg-yellow-100' }} rounded-full">
                                        {{ $transaction->statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->type == \App\Models\UserTransaction::TYPE_CREDIT)
                                        @if($transaction->sender_id)
                                            <div class="text-sm text-gray-900">From: {{ optional($transaction->sender)->name ?? 'System' }}</div>
                                        @else
                                            <div class="text-sm text-gray-900">From: System</div>
                                        @endif
                                    @else
                                        @if($transaction->receiver_id)
                                            <div class="text-sm text-gray-900">To: {{ optional($transaction->receiver)->name ?? 'System' }}</div>
                                        @else
                                            <div class="text-sm text-gray-900">To: System</div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                <p class="mt-1 text-sm text-gray-500">You don't have any transaction records yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
