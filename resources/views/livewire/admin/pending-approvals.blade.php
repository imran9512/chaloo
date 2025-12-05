<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold mb-6">{{ __('Pending Approvals') }}</h2>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @forelse ($pendingUsers as $user)
                    <div
                        class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4 border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Details -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">User Information</h3>
                                <div class="space-y-2">
                                    <div>
                                        <span class="font-semibold">Name:</span>
                                        <span class="ml-2">{{ $user->name }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Email:</span>
                                        <span class="ml-2">{{ $user->email }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Phone:</span>
                                        <span class="ml-2">{{ $user->phone }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">City:</span>
                                        <span class="ml-2">{{ $user->city }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Role:</span>
                                        <span class="ml-2 capitalize">{{ $user->role }}</span>
                                    </div>
                                    @if($user->company_name)
                                        <div>
                                            <span class="font-semibold">Company:</span>
                                            <span class="ml-2">{{ $user->company_name }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-semibold">Registered:</span>
                                        <span class="ml-2">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">Uploaded Documents</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- ID Card -->
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">ID Card (Front)</p>
                                        @if($user->id_card_image)
                                            <x-lightbox-image :src="route('storage.serve', ['path' => $user->id_card_image], false)" alt="ID Card Front" />
                                        @else
                                            <span class="text-red-500 text-xs">Missing</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">ID Card (Back)</p>
                                        @if($user->id_card_back_image)
                                            <x-lightbox-image :src="route('storage.serve', ['path' => $user->id_card_back_image], false)" alt="ID Card Back" />
                                        @else
                                            <span class="text-red-500 text-xs">Missing</span>
                                        @endif
                                    </div>

                                    <!-- License -->
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">License (Front)</p>
                                        @if($user->license_image)
                                            <x-lightbox-image :src="route('storage.serve', ['path' => $user->license_image], false)" alt="License Front" />
                                        @else
                                            <span class="text-red-500 text-xs">Missing</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">License (Back)</p>
                                        @if($user->license_back_image)
                                            <x-lightbox-image :src="route('storage.serve', ['path' => $user->license_back_image], false)" alt="License Back" />
                                        @else
                                            <span class="text-red-500 text-xs">Missing</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex gap-3 justify-end">
                            <button wire:click="approve({{ $user->id }})"
                                wire:confirm="Are you sure you want to approve {{ $user->name }}?"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                                ✓ Approve
                            </button>
                            <button wire:click="reject({{ $user->id }})"
                                wire:confirm="Are you sure you want to reject {{ $user->name }}?"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                ✗ Reject
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No pending approvals</h3>
                        <p class="mt-1 text-sm text-gray-500">All registrations have been processed.</p>
                    </div>
                @endforelse

                @if($pendingUsers->hasPages())
                    <div class="mt-6">
                        {{ $pendingUsers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>