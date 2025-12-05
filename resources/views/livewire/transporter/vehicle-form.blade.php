<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold mb-6">{{ $vehicle ? 'Edit Vehicle' : 'Add New Vehicle' }}</h2>

                <form wire:submit="save">
                    <!-- Company Management Option -->
                    <div
                        class="mb-8 p-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg border border-indigo-200 dark:border-indigo-700">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" wire:model.live="is_company_managed"
                                class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900 dark:text-white">Hand over to Company
                                    (Managed Service)</span>
                                <span class="block text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    If checked, the company will handle client interactions for this vehicle.
                                    The company will deduct a <strong>{{ $commission_percentage }}% service fee</strong>
                                    from your earnings.
                                </span>
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Type -->
                        <div>
                            <x-input-label for="vehicle_type_id" :value="__('Vehicle Type')" />
                            <select wire:model="vehicle_type_id" id="vehicle_type_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->capacity }} seats)</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_type_id')" class="mt-2" />
                        </div>

                        <!-- Vehicle Name (Required) -->
                        <div>
                            <x-input-label for="name" :value="__('Vehicle Name (e.g. Toyota Corolla GLI) *')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Model (Required) -->
                        <div>
                            <x-input-label for="model" :value="__('Model *')" />
                            <x-text-input wire:model="model" id="model" class="block mt-1 w-full" type="text"
                                required />
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <!-- Brand (Optional) -->
                        <div>
                            <x-input-label for="brand" :value="__('Brand')" />
                            <x-text-input wire:model="brand" id="brand" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>

                        <!-- Registration Number (Optional) -->
                        <div>
                            <x-input-label for="registration_number" :value="__('Registration Number')" />
                            <x-text-input wire:model="registration_number" id="registration_number"
                                class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
                        </div>

                        <!-- Color (Optional) -->
                        <div>
                            <x-input-label for="color" :value="__('Color')" />
                            <x-text-input wire:model="color" id="color" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <!-- Daily Rate (Required) -->
                        <div>
                            <x-input-label for="daily_rate" :value="__('Daily Rate (PKR) *')" />
                            <x-text-input wire:model.live="daily_rate" id="daily_rate" class="block mt-1 w-full"
                                type="number" step="0.01" required />
                            <x-input-error :messages="$errors->get('daily_rate')" class="mt-2" />

                            @if($is_company_managed && $daily_rate)
                                <div
                                    class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-700">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <span class="font-semibold">Customer Pays:</span> Rs.
                                        {{ number_format($daily_rate, 2) }}
                                    </p>
                                    <p class="text-sm text-green-700 dark:text-green-400 font-bold mt-1">
                                        <span class="font-semibold">You Earn:</span> Rs.
                                        {{ number_format($net_earnings, 2) }}
                                        <span class="text-xs">(After {{ $commission_percentage }}% service fee)</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Driver Fee (Optional) -->
                        <div>
                            <x-input-label for="driver_fee" :value="__('Driver Fee (PKR)')" />
                            <x-text-input wire:model="driver_fee" id="driver_fee" class="block mt-1 w-full"
                                type="number" step="0.01" />
                            <x-input-error :messages="$errors->get('driver_fee')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Driver fee is not subject to commission</p>
                        </div>

                        <!-- City (Required) -->
                        <div>
                            <x-input-label for="city" :value="__('City *')" />
                            <x-text-input wire:model="city" id="city" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Special Note (Optional) -->
                    <div class="mt-6">
                        <x-input-label for="description" :value="__('Special Note')" />
                        <textarea wire:model="description" id="description" rows="4"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Status Selection -->
                    <div class="mt-6">
                        <x-input-label for="status" :value="__('Vehicle Status *')" />
                        <select wire:model.live="status" id="status"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="available_from_date">Available on Date</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Available From Date (Conditional) -->
                    @if($status === 'available_from_date')
                        <div class="mt-6">
                            <x-input-label for="available_from_date" :value="__('Available From Date *')" />
                            <x-text-input wire:model="available_from_date" id="available_from_date"
                                class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('available_from_date')" class="mt-2" />
                        </div>
                    @endif

                    <!-- Features (Optional) -->
                    <div class="mt-6">
                        <x-input-label :value="__('Features (e.g. AC, GPS, Bluetooth)')" />
                        <div class="flex gap-2 mt-1">
                            <x-text-input wire:model="featureInput" wire:keydown.enter.prevent="addFeature"
                                class="block w-full" type="text" placeholder="Type feature and press Enter" />
                            <button type="button" wire:click="addFeature"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Add</button>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($features as $index => $feature)
                                <span
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 flex items-center">
                                    {{ $feature }}
                                    <button type="button" wire:click="removeFeature({{ $index }})"
                                        class="ml-2 text-blue-600 hover:text-blue-900">×</button>
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Vehicle Images (Required) -->
                    <div class="mt-6">
                        <x-input-label :value="__('Vehicle Images *')" />

                        <div class="mt-2 flex gap-2">
                            <label class="flex-1 cursor-pointer">
                                <div
                                    class="flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Choose
                                        Files</span>
                                </div>
                                <input type="file" wire:model="newImages" multiple accept="image/*" class="hidden">
                            </label>

                            <label class="cursor-pointer" title="Take Photo">
                                <div
                                    class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="file" wire:model="newImages" accept="image/*" capture="environment"
                                    class="hidden">
                            </label>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">Upload images up to 50MB each. They will be automatically
                            optimized to WebP format.</p>
                        <x-input-error :messages="$errors->get('temporaryImages.*')" class="mt-2" />

                        <div wire:loading wire:target="newImages" class="mt-2 text-sm text-indigo-600">
                            Uploading images...
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <!-- Existing Images -->
                            @foreach($existingImages as $index => $image)
                                <div class="relative group">
                                    <img src="{{ route('storage.serve', ['path' => $image], false) }}"
                                        class="w-full h-32 object-cover rounded border-2 border-gray-300">
                                    <button type="button" wire:click="removeImage({{ $index }})"
                                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <div
                                        class="absolute bottom-1 left-1 bg-blue-500 text-white text-xs px-2 py-0.5 rounded">
                                        Saved
                                    </div>
                                </div>
                            @endforeach

                            <!-- Temporary Image Previews -->
                            @foreach($temporaryImages as $index => $image)
                                <div class="relative group">
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="w-full h-32 object-cover rounded border-2 border-green-500">
                                    <button type="button" wire:click="removeTemporaryImage({{ $index }})"
                                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <div
                                        class="absolute bottom-1 left-1 bg-green-500 text-white text-xs px-2 py-0.5 rounded">
                                        New
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if(count($existingImages) + count($temporaryImages) === 0)
                            <div
                                class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    <strong>Note:</strong> Please upload at least one image of your vehicle.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('transporter.vehicles') }}"
                            class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $vehicle ? 'Update Vehicle' : 'Create Vehicle' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>