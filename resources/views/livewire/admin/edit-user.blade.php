<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Edit User: {{ $user->name }}</h2>
                    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:underline">← Back to Users</a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button wire:click="setTab('details')"
                            class="{{$activeTab === 'details' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            User Details
                        </button>
                        @if($user->role === 'transporter')
                            <button wire:click="setTab('vehicles')"
                                class="{{$activeTab === 'vehicles' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Vehicles
                            </button>
                        @endif
                        @if($user->role === 'agent')
                            <button wire:click="setTab('tours')"
                                class="{{$activeTab === 'tours' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Tours
                            </button>
                        @endif
                    </nav>
                </div>

                <!-- User Details Tab -->
                @if($activeTab === 'details')
                    <form wire:submit="updateUser">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Name *')" />
                                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email *')" />
                                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input wire:model="city" id="city" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            @if($user->role === 'transporter')
                                <div>
                                    <x-input-label for="company_name" :value="__('Company Name')" />
                                    <x-text-input wire:model="company_name" id="company_name" class="block mt-1 w-full" type="text" />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>
                            @endif

                            <div>
                                <x-input-label for="status" :value="__('Status *')" />
                                <select wire:model="status" id="status"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="pending_approval">Pending Approval</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update User
                            </button>
                        </div>
                    </form>

                    <!-- Password Reset Section (Admin Only) -->
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold mb-4">Reset Password</h3>
                            <form wire:submit="resetPassword">
                                <div class="max-w-md">
                                    <x-input-label for="new_password" :value="__('New Password')" />
                                    <x-text-input wire:model="new_password" id="new_password" class="block mt-1 w-full" type="password" />
                                    <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                                    <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif

                <!-- Vehicles Tab -->
                @if($activeTab === 'vehicles' && $user->role === 'transporter')
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Name</th>
                                    <th class="py-2 px-4 border-b text-left">Type</th>
                                    <th class="py-2 px-4 border-b text-left">Rate</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                    <th class="py-2 px-4 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vehicles as $vehicle)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b font-medium">{{ $vehicle->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $vehicle->type->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border-b">PKR {{ number_format($vehicle->daily_rate, 0) }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <div x-data="{ 
                                                status: '{{ $vehicle->status }}', 
                                                date: '{{ $vehicle->available_from_date?->format('Y-m-d') ?? '' }}',
                                                showDatePicker: {{ $vehicle->status === 'available_from_date' ? 'true' : 'false' }}
                                            }">
                                                <select 
                                                    x-model="status" 
                                                    @change="showDatePicker = (status === 'available_from_date'); if (status !== 'available_from_date') { $wire.call('updateVehicleStatus', {{ $vehicle->id }}, status) }"
                                                    class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                                    <option value="available">Available</option>
                                                    <option value="booked">Booked</option>
                                                    <option value="available_from_date">Available on Date</option>
                                                </select>
                                                
                                                <div x-show="showDatePicker" class="mt-2">
                                                    <input 
                                                        type="date" 
                                                        x-model="date"
                                                        @change="$wire.call('updateVehicleStatus', {{ $vehicle->id }}, 'available_from_date', date)"
                                                        class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                                    <div x-show="date" class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                        Available: <span x-text="new Date(date).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('transporter.vehicles.edit', $vehicle->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <button wire:click="deleteVehicle({{ $vehicle->id }})" 
                                                wire:confirm="Are you sure you want to delete this vehicle?"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">No vehicles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $vehicles->links() }}
                    </div>
                @endif

                <!-- Tours Tab -->
                @if($activeTab === 'tours' && $user->role === 'agent')
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Title</th>
                                    <th class="py-2 px-4 border-b text-left">Destinations</th>
                                    <th class="py-2 px-4 border-b text-left">Duration</th>
                                    <th class="py-2 px-4 border-b text-left">Price/Person</th>
                                    <th class="py-2 px-4 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tours as $tour)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b font-medium">{{ $tour->title }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tour->destinations }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tour->duration_days }}D / {{ $tour->duration_nights }}N</td>
                                        <td class="py-2 px-4 border-b">PKR {{ number_format($tour->price_per_person ?? 0, 0) }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <button wire:click="deleteTour({{ $tour->id }})" 
                                                wire:confirm="Are you sure you want to delete this tour?"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">No tours found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $tours->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>