<!-- Referral Code Section -->
<div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg border border-indigo-100 px-2 py-2">
    <div class="flex flex-col justify-center items-center">
        <div class="flex justify-center items-center">
            <h3 class="font-medium flex items-center">
                <i data-lucide="users" class="h-4 w-4 text-indigo-500 mr-2"></i>
                Your Connection Code
            </h3>
        </div>

        <div class="flex items-center mt-2 w-11/12">
            <div class="relative flex-grow">
                <div class="flex items-center justify-between bg-white border border-indigo-200 rounded-lg px-2 py-1">
                    <div class="flex items-center w-full justify-center">
                        <p id="referral-code"
                            class="font-mono text-center font-semibold tracking-wider text-indigo-700">
                        @if ($user->is_premium)
                            {{ $user->reference_code ?? 'Please contact admin' }}
                        @else
                            <div class="flex items-center">
                                <i data-lucide="lock" class="h-4 w-4 text-indigo-500 mr-2"></i>
                                Please upgrade to premium
                            </div>
                        @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
