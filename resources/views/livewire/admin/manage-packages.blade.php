<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Manage Packages</h2>
                    @if(!$showForm)
                        <button wire:click="create"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Package
                        </button>
                    @endif
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                @if($showForm)
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-6 rounded">
                        <h3 class="text-lg font-semibold mb-4">{{ $editingId ? 'Edit Package' : 'Create New Package' }}</h3>
                        <form wire:submit="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="name" :value="__('Package Name *')" />
                                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text"
                                        required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="type" :value="__('Type *')" />
                                    <select wire:model="type" id="type" required
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="transporter">Transporter</option>
                                        <option value="agent">Agent</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="listing_limit" :value="__('Listing Limit *')" />
                                    <x-text-input wire:model="listing_limit" id="listing_limit" class="block mt-1 w-full"
                                        type="number" min="1" required />
                                    <x-input-error :messages="$errors->get('listing_limit')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="price" :value="__('Price (PKR) *')" />
                                    <x-text-input wire:model="price" id="price" class="block mt-1 w-full" type="number"
                                        step="0.01" min="0" required />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="duration_days" :value="__('Duration (Days) *')" />
                                    <x-text-input wire:model="duration_days" id="duration_days" class="block mt-1 w-full"
                                        type="number" min="1" required />
                                    <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ $editingId ? 'Update' : 'Create' }} Package
                                </button>
                                <button type="button" wire:click="resetForm"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Packages List -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($packages as $package)
                        <div
                            class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 {{ $package->is_active ? '' : 'opacity-50' }}">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold">{{ $package->name }}</h3>
                                <span
                                    class="px-2 py-1 text-xs rounded {{ $package->type === 'transporter' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($package->type) }}
                                </span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <p class="text-2xl font-bold text-blue-600">PKR {{ number_format($package->price, 0) }}</p>
                                <p class="text-sm"><strong>Listings:</strong> {{ $package->listing_limit }}</p>
                                <p class="text-sm"><strong>Duration:</strong> {{ $package->duration_days }} days</p>
                                <p class="text-sm">
                                    <span
                                        class="px-2 py-1 text-xs rounded {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $package->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <button wire:click="edit({{ $package->id }})"
                                    class="text-blue-600 hover:text-blue-900 text-sm">Edit</button>
                                <button wire:click="toggleStatus({{ $package->id }})"
                                    class="text-orange-600 hover:text-orange-900 text-sm">
                                    {{ $package->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button wire:click="delete({{ $package->id }})" wire:confirm="Are you sure?"
                                    class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            No packages found. Create your first package!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>