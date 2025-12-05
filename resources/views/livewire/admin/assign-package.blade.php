<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Assign Package: {{ $user->name }}</h2>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">←
                        Back</a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Current Package Status -->
                @if($currentPackage)
                    <div class="mb-6 bg-blue-50 dark:bg-blue-900 p-4 rounded border-l-4 border-blue-500">
                        <h3 class="font-semibold text-lg mb-3">📦 Current Active Package</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><strong>Package:</strong> {{ $currentPackage->package->name ?? 'Custom Package' }}</div>
                            <div><strong>Price Paid:</strong> PKR {{ number_format($currentPackage->price_paid) }}</div>
                            package to create listings.</p>
                        </div>
                @endif

                    <!-- Assign New Package Form -->
                    <h3 class="text-lg font-semibold mb-4">Assign New Package</h3>
                    <form wire:submit="assignPackage">
                        @if(\App\Helpers\PermissionHelper::hasPermission(auth()->user(), 'manage_packages_edit') || auth()->user()->role === 'admin')
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="is_custom" class="rounded">
                                    <span class="ml-2">Create Custom Package</span>
                                </label>
                            </div>
                        @endif

                        @if(!$is_custom)
                            <div class="mb-4">
                                <x-input-label for="package_id" :value="__('Select Package')" />
                                <select wire:model.live="package_id" id="package_id" required
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Select Package --</option>
                                    @foreach($packages as $pkg)
                                        <option value="{{ $pkg->id }}">{{ $pkg->name }} - PKR {{ number_format($pkg->price) }}
                                            ({{ $pkg->listing_limit }} listings, {{ $pkg->duration_days }} days)</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="listing_limit" :value="__('Listing Limit *')" />
                                <x-text-input wire:model="listing_limit" id="listing_limit" class="block mt-1 w-full"
                                    type="number" min="1" required />
                                <x-input-error :messages="$errors->get('listing_limit')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="price_paid" :value="__('Price (PKR) *')" />
                                <x-text-input wire:model="price_paid" id="price_paid" class="block mt-1 w-full"
                                    type="number" step="0.01" min="0" required />
                                <x-input-error :messages="$errors->get('price_paid')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="started_at" :value="__('Start Date *')" />
                                <x-text-input wire:model.live="started_at" id="started_at" class="block mt-1 w-full"
                                    type="date" required />
                                <x-input-error :messages="$errors->get('started_at')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="duration_days" :value="__('Duration (Days) *')" />
                                <x-text-input wire:model.live="duration_days" id="duration_days"
                                    class="block mt-1 w-full" type="number" min="1" required />
                                <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="expires_at" :value="__('Expiry Date *')" />
                                <x-text-input wire:model="expires_at" id="expires_at" class="block mt-1 w-full"
                                    type="date" required />
                                <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Assign Package
                            </button>
                        </div>
                    </form>

                    <!-- Package History -->
                    @if($packageHistory->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Package History</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 border">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b text-left">Package</th>
                                            <th class="py-2 px-4 border-b text-left">Listings</th>
                                            <th class="py-2 px-4 border-b text-left">Price</th>
                                            <th class="py-2 px-4 border-b text-left">Period</th>
                                            <th class="py-2 px-4 border-b text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($packageHistory as $history)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $history->package->name ?? 'Custom' }}</td>
                                                <td class="py-2 px-4 border-b">{{ $history->listing_limit }}</td>
                                                <td class="py-2 px-4 border-b">PKR {{ number_format($history->price_paid) }}
                                                </td>
                                                <td class="py-2 px-4 border-b text-sm">
                                                    {{ $history->started_at->format('d M Y') }} -
                                                    {{ $history->expires_at->format('d M Y') }}
                                                </td>
                                                <td class="py-2 px-4 border-b">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded {{ $history->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($history->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>