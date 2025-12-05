<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transporter Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Package Status Widget -->
            @php
                $activePackage = \App\Models\UserPackage::where('user_id', auth()->id())
                    ->where('status', 'active')
                    ->first();
                $vehicleCount = auth()->user()->vehicles()->count();
            @endphp
            
            @if($activePackage && $activePackage->isActive())
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        <h3 class="text-lg font-semibold mb-3">📦 Your Package: {{ $activePackage->package->name ?? 'Custom Package' }}</h3>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <div class="text-blue-100">Listings</div>
                                <div class="text-2xl font-bold">{{ $vehicleCount }} / {{ $activePackage->listing_limit }}</div>
                            </div>
                            <div>
                                <div class="text-blue-100">Days Left</div>
                                <div class="text-2xl font-bold">{{ max(0, now()->diffInDays($activePackage->expires_at, false)) }}</div>
                            </div>
                            <div>
                                <div class="text-blue-100">Expires On</div>
                                <div class="text-lg font-semibold">{{ $activePackage->expires_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        @if($vehicleCount >= $activePackage->listing_limit)
                            <div class="mt-3 bg-yellow-500 text-yellow-900 px-3 py-2 rounded text-sm">
                                ⚠️ Listing limit reached! Upgrade to add more vehicles.
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('transporter.buy-packages') }}" class="inline-block bg-white text-blue-600 hover:bg-blue-50 font-bold py-2 px-4 rounded border border-white">
                                🔄 Upgrade Package
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4">
                    <p class="text-yellow-800 font-semibold mb-3">⚠️ No active package. Purchase a package to start listing vehicles.</p>
                    <a href="{{ route('transporter.buy-packages') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        📦 Buy Packages
                    </a>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">{{ __("Welcome back, Transporter!") }}</h3>

                    @if(auth()->user()->status !== 'active')
                        <!-- Red Warning for Unapproved Users -->
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">⚠️ Account Not Approved</p>
                            <p>Your account is not yet approved. Please complete the activation process below to get approved by our admin team. Until approval, your vehicle listings will not be visible to agents.</p>
                        </div>

                        @if(auth()->user()->status === 'pending_approval')
                            <div class="mt-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                                <p class="font-bold">Account Pending Approval</p>
                                <p>Your documents have been submitted and are under review. You will be notified once your account is active.</p>
                            </div>
                        @else
                            <div class="mt-6">
                                @livewire('shared.activation-form')
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>