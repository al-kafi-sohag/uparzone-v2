@extends('user.layout.master')

@section('title', __('Profile'))

@push('styles')
@endpush

@section('content')
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-4 flex items-center justify-between">
            <a href="{{ route('user.home') }}" id="back-button" class="p-2">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
            </a>
            <h1 class="text-lg font-semibold">Update Your Information</h1>
            <div class="w-8"></div> <!-- Spacer for alignment -->
        </div>
    </div>

    <!-- Profile Update Form -->
    <div class="px-4 py-6">
        {{-- <div class="mb-8 flex flex-col items-center">
            <div class="relative mb-3">
                <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-white shadow-md">
                    <img id="profile-preview" src="https://via.placeholder.com/96" alt="Profile"
                        class="h-full w-full object-cover">
                </div>
                <button type="button" id="change-photo-btn"
                    class="absolute bottom-0 right-0 bg-purple-600 text-white rounded-full p-2 shadow-md">
                    <i data-lucide="camera" class="h-4 w-4"></i>
                </button>
                <input type="file" id="profile-upload" class="hidden" accept="image/*">
            </div>
            <p class="text-sm text-gray-500">Tap to change your profile picture</p>
        </div> --}}

        <!-- Form Sections -->
        {{-- <div class="space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="user" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Personal Information
                </h2>

                <div class="form-group mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" value="Jane Doe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter your full name</span>
                </div>

                <div class="form-group mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" value="janedoe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Username must be at least 3 characters</span>
                </div>

                <div class="form-group mb-4">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <textarea id="bio" name="bio" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">Digital creator & photographer. Sharing my journey through life one photo at a time. ✨</textarea>
                    <div class="flex justify-between mt-1">
                        <span class="error-message">Bio is too long</span>
                        <span id="bio-counter" class="text-xs text-gray-500">0/150</span>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" id="birthdate" name="birthdate" value="1990-01-15"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter a valid date</span>
                </div>

                <div class="form-group">
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select id="gender" name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <option value="female" selected>Female</option>
                        <option value="male">Male</option>
                        <option value="non-binary">Non-binary</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="mail" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Contact Information
                </h2>

                <div class="form-group mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" value="jane.doe@example.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter a valid email address</span>
                </div>

                <div class="form-group mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="+1 (555) 123-4567"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter a valid phone number</span>
                </div>

                <div class="form-group">
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url" id="website" name="website" value="https://janedoe.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter a valid URL</span>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="map-pin" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Address Information
                </h2>

                <div class="form-group mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                    <input type="text" id="address" name="address" value="123 Main St"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter your street address</span>
                </div>

                <div class="form-group mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" id="city" name="city" value="New York"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <span class="error-message">Please enter your city</span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                        <input type="text" id="state" name="state" value="NY"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <span class="error-message">Required</span>
                    </div>

                    <div class="form-group">
                        <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code</label>
                        <input type="text" id="zip" name="zip" value="10001"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <span class="error-message">Required</span>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <select id="country" name="country" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <option value="us" selected>United States</option>
                        <option value="ca">Canada</option>
                        <option value="uk">United Kingdom</option>
                        <option value="au">Australia</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="shield" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Privacy Settings
                </h2>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium">Profile Visibility</p>
                            <p class="text-xs text-gray-500">Make your profile visible to others</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="profile-visibility" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium">Email Notifications</p>
                            <p class="text-xs text-gray-500">Receive email updates and newsletters</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="email-notifications" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium">Two-Factor Authentication</p>
                            <p class="text-xs text-gray-500">Add an extra layer of security</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="two-factor" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="space-y-6">



            <!-- Privacy Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="user" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Referal Settings
                </h2>

                <div class="space-y-3">
                    @if ($user->referer)
                    <div class="flex items-center justify-between">
                        <p>{{ __('Referrer Name') }}</p>
                        <p>{{ $user->referer->name }}</p>
                    </div>
                    @else
                    <form action="{{ route('user.cp.update.reference') }}" method="POST">
                        @csrf
                        <p>{{ __('Add Your Referrer') }}</p>
                        <div class="flex items-center justify-between">
                            <input type="text" name="reference_code" value=""
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <button type="submit"
                            class="w-full mt-4 bg-purple-600 text-white py-3 px-4 rounded-md font-medium hover:bg-purple-700 transition-colors">
                            {{ __('Submit') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-md font-semibold mb-4 flex items-center">
                    <i data-lucide="list" class="h-5 w-5 mr-2 text-purple-600"></i>
                    Referal History
                </h2>

                <div class="space-y-3">
                    @if ($user->is_premium)
                    <div>
                        <div class="flex items-center justify-between">
                            <p>{{ __('Total Referral') }}</p>
                            <p>{{ $user->total_referral }}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p>{{ __('Premium Referral') }}</p>
                            <p>{{ $user->premium_referral_count }}</p>
                        </div>

                        <div>
                            <div class="overflow-x-auto mt-4">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Name') }}</th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Status') }}</th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Amount') }}</th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($user->referrals as $referral)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"> {{ $referral->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 {{ $referral->isPremiumBadge }} rounded-full">
                                                        {{ $referral->isPremiumText }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-green-600">
                                                        {{ number_format(200, 2) }} tk
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $referral->created_at->format('d M, Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ $referral->created_at->format('h:i A') }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ __('No referrals found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-between">
                        <p>{{ __('Total Referral') }}</p>
                        <p>{{ __('Please upgrade to premium') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        {{-- <div class="mt-8">
            <button type="submit"
                class="w-full bg-purple-600 text-white py-3 px-4 rounded-md font-medium hover:bg-purple-700 transition-colors">
                Save Changes
            </button>
            <button type="button" id="cancel-button"
                class="w-full mt-3 border border-gray-300 bg-white text-gray-700 py-3 px-4 rounded-md font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </button>
        </div> --}}
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-5/6 max-w-sm">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="check" class="h-8 w-8 text-green-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Profile Updated!</h3>
                <p class="text-gray-600 mb-6">Your information has been successfully updated.</p>
                <button id="success-ok-btn"
                    class="w-full bg-purple-600 text-white py-2 px-4 rounded-md font-medium hover:bg-purple-700 transition-colors">
                    OK
                </button>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
