@extends('user.layout.master')

@section('title', __('Wallet'))


@push('styles')
    <style>
        #premium-badge {
            background-color: #14b8a6;
            color: white;
        }

        #general-badge {
            background-color: #f59e0b;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="px-4 py-4">
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6 pb-2">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">{{ __('My Wallet') }}</h2>
                    <span id="{{ $user->is_premium ? 'premium-badge' : 'general-badge' }}"
                        class="inline-flex items-center rounded-full border border-gray-200 px-2.5 py-0.5 text-xs font-semibold">
                        {{ $user->is_premium ? __('Premium') : __('General') }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">{{ __('Manage your funds and transactions') }}</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('Available Balance') }}</h3>
                        @if ($user->is_premium)
                            <div class="flex items-center">
                                <i data-lucide="check" class="h-7 w-7 text-green-500 mr-2"></i>
                                <p id="balance" class="text-3xl font-bold">{{ number_format($user->balance) }} tk</p>
                            </div>
                        @else
                            <div class="flex items-center">
                                <i data-lucide="lock" class="h-7 w-7 text-red-500 mr-2"></i>
                                <p id="balance" class="text-3xl font-bold text-red-500">{{ number_format($user->balance) }} tk
                                </p>
                            </div>
                            <small>{{ __('You need to upgrade to premium to withdraw') }}</small>
                        @endif
                    </div>

                    @if ($user->is_premium)
                        <!-- Withdrawal Form (Hidden by default)-->
                        <div id="withdrawal-form" class="space-y-4 hidden">
                            <div>
                                <label for="withdrawAmount" class="block text-sm font-medium">Withdrawal Amount</label>
                                <input id="withdrawAmount" type="number" placeholder="Minimum 500 tk"
                                    class="mt-1.5 w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label for="gateway" class="block text-sm font-medium">Payment Gateway</label>
                                <div class="grid grid-cols-2 gap-2 mt-1.5">
                                    <button type="button" id="bkash-button"
                                        class="gateway-button border border-gray-300 rounded-md py-2 px-4 text-sm font-medium"
                                        data-gateway="bkash">
                                        bKash
                                    </button>
                                    <button type="button" id="nagad-button"
                                        class="gateway-button border border-gray-300 rounded-md py-2 px-4 text-sm font-medium"
                                        data-gateway="nagad">
                                        Nagad
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="accountNumber" class="block text-sm font-medium">Account Number</label>
                                <input id="accountNumber" type="text" placeholder="11-digit number" maxlength="11"
                                    class="mt-1.5 w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label for="district" class="block text-sm font-medium">District</label>
                                <select id="district" class="mt-1.5 w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                    <option value="">Select district</option>
                                    <option value="dhaka">Dhaka</option>
                                    <option value="dinajpur">Dinajpur</option>
                                    <option value="kurigram">Kurigram</option>
                                    <option value="chittagong">Chittagong</option>
                                    <option value="sylhet">Sylhet</option>
                                    <option value="rajshahi">Rajshahi</option>
                                    <option value="khulna">Khulna</option>
                                    <option value="barisal">Barisal</option>
                                    <option value="rangpur">Rangpur</option>
                                    <option value="mymensingh">Mymensingh</option>
                                </select>
                            </div>

                            <p id="error-message" class="text-sm text-red-500 hidden"></p>

                            <button id="withdraw-button"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                Submit Withdrawal Request
                            </button>

                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4 flex items-start">
                                <i data-lucide="clock" class="h-4 w-4 text-blue-500 mt-0.5 mr-2"></i>
                                <p class="text-sm text-blue-700">
                                    Withdrawal requests are processed within 1 hour - 5 working days after submission.
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Premium Subscription Section -->
                        <div id="premium-section" class="border border-amber-200 bg-amber-50 rounded-lg p-6">
                            <div class="flex flex-col items-center text-center space-y-4">
                                <div>
                                    <i data-lucide="shield" class="h-12 w-12 text-amber-500"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold">{{ __('Upgrade to Premium') }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ __('Unlock withdrawal features and more benefits') }}</p>
                                </div>

                                <ul class="text-sm space-y-2 text-left w-full">
                                    <li class="flex items-center">
                                        <i data-lucide="check" class="h-4 w-4 mr-2 text-green-500"></i>
                                        <span>{{ __('Personal referral code') }}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i data-lucide="check" class="h-4 w-4 mr-2 text-green-500"></i>
                                        <span>{{ __('Withdraw balance anytime') }}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i data-lucide="check" class="h-4 w-4 mr-2 text-green-500"></i>
                                        <span>{{ __('Priority customer support') }}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i data-lucide="check" class="h-4 w-4 mr-2 text-green-500"></i>
                                        <span>{{ __('Higher activity bonus') }}</span>
                                    </li>
                                </ul>

                                <div class="w-full pt-2">
                                    <div class="flex justify-center mb-4">
                                        <span class="text-2xl font-bold">{{ config('app.premium_price') }} tk</span>
                                        <span class="text-gray-500 ml-1 self-end mb-1">one-time</span>
                                    </div>

                                    <a id="pay-button" href="{{ route('user.payment.init') }}"
                                        class="w-full flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-md">
                                        <i data-lucide="credit-card" class="mr-2 h-4 w-4"></i>
                                        <span>Pay with SSL Commerz</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('user/js/wallet.js') }}"></script>
@endpush
