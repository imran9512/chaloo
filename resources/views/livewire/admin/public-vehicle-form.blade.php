<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ $vehicle ? 'Edit Public Vehicle' : 'Add Public Vehicle' }}</h2>
                    <a href="{{ route('admin.vehicles') }}"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                        &larr; Back to List
                    </a>
                </div>

                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Type -->
                        <div>
                            <x-input-label for="vehicle_type_id" :value="__('Vehicle Type *')" />
                            <select wire:model="vehicle_type_id" id="vehicle_type_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->capacity }} seats)</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_type_id')" class="mt-2" />
                        </div>

                        <!-- Vehicle Name -->
                        <div>
                            <x-input-label for="name" :value="__('Vehicle Name (e.g. Toyota Corolla GLI) *')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Model -->
                        <div>
                            <x-input-label for="model" :value="__('Model *')" />
                            <x-text-input wire:model="model" id="model" class="block mt-1 w-full" type="text"
                                required />
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <!-- Brand -->
                        <div>
                            <x-input-label for="brand" :value="__('Brand')" />
                            <x-text-input wire:model="brand" id="brand" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>

                        <!-- Year -->
                        <div>
                            <x-input-label for="year" :value="__('Year')" />
                            <x-text-input wire:model="year" id="year" class="block mt-1 w-full" type="number" />
                            <x-input-error :messages="$errors->get('year')" class="mt-2" />
                        </div>

                        <!-- Registration Number -->
                        <div>
                            <x-input-label for="registration_number" :value="__('Registration Number')" />
                            <x-text-input wire:model="registration_number" id="registration_number"
                                class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
                        </div>

                        <!-- Color -->
                        <div>
                            <x-input-label for="color" :value="__('Color')" />
                            <x-text-input wire:model="color" id="color" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <!-- Daily Rate -->
                        <div>
                            <x-input-label for="daily_rate" :value="__('Daily Rate (PKR) *')" />
                            <x-text-input wire:model="daily_rate" id="daily_rate" class="block mt-1 w-full"
                                type="number" step="0.01" required />
                            <x-input-error :messages="$errors->get('daily_rate')" class="mt-2" />
                        </div>

                        <!-- Driver Fee -->
                        <div>
                            <x-input-label for="driver_fee" :value="__('Driver Fee (PKR)')" />
                            <x-text-input wire:model="driver_fee" id="driver_fee" class="block mt-1 w-full"
                                type="number" step="0.01" />
                            <x-input-error :messages="$errors->get('driver_fee')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div>
                            <x-input-label for="city" :value="__('City *')" />
                            <x-text-input wire:model="city" id="city" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <x-input-label for="description" :value="__('Description / Special Note')" />
                        <textarea wire:model="description" id="description" rows="4"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="mt-6">
                        <x-input-label for="status" :value="__('Status *')" />
                        <select wire:model.live="status" id="status"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="available_from_date">Available on Date</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    @if($status === 'available_from_date')
                        <div class="mt-6">
                            <x-input-label for="available_from_date" :value="__('Available From Date *')" />
                            <x-text-input wire:model="available_from_date" id="available_from_date"
                                class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('available_from_date')" class="mt-2" />
                        </div>
                    @endif

                    <!-- Features -->
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

                    <!-- Images -->
                    <div class="mt-6">
                        <x-input-label :value="__('Vehicle Images *')" />
                        <input type="file" wire:model="newImages" multiple
                            class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        <x-input-error :messages="$errors->get('newImages.*')" class="mt-2" />

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            @foreach($existingImages as $index => $image)
                                <div class="relative group">
                                    <img src="{{ asset('uploads/' . $image) }}" class="w-full h-32 object-cover rounded">
                                    <button type="button" wire:click="removeImage({{ $index }})"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach

                            @if($newImages)
                                @foreach($newImages as $image)
                                    <div class="relative">
                                        <img src="{{ $image->temporaryUrl() }}"
                                            class="w-full h-32 object-cover rounded border-2 border-green-500">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.vehicles') }}"
                            class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="button" wire:click="save"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $vehicle ? 'Update Vehicle' : 'Create Vehicle' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>