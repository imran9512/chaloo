<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">{{ __('Public Fleet Management') }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage vehicles visible on the public
                            website</p>
                    </div>
                    <a href="{{ route('admin.vehicles.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Public Vehicle
                    </a>
                </div>

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

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Vehicle</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Owner</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Type</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Rate (PKR)</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    City</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Status</th>
                                <th class="py-3 px-4 border-b text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicles as $vehicle)
                                <tr
                                    class="hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ !$vehicle->is_approved && $vehicle->is_company_managed ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                                    <td class="py-3 px-4 border-b">
                                        <div class="flex items-center">
                                            @if($vehicle->images && count($vehicle->images) > 0)
                                                <img src="{{ asset('uploads/' . $vehicle->images[0]) }}"
                                                    class="rounded-full object-cover mr-3" style="width: 40px; height: 40px;">
                                            @else
                                                <div class="rounded-full bg-gray-200 flex items-center justify-center mr-3"
                                                    style="width: 40px; height: 40px;">🚗</div>
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $vehicle->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $vehicle->model }}
                                                    ({{ $vehicle->year }})</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 border-b">
                                        <div class="text-sm">
                                            {{ $vehicle->user->name }}
                                            @if($vehicle->is_company_managed)
                                                <span class="block text-xs text-blue-600 font-semibold">Managed</span>
                                            @else
                                                <span class="block text-xs text-gray-500">Direct</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 border-b">{{ $vehicle->type->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <div class="font-mono">{{ number_format($vehicle->daily_rate, 0) }}</div>
                                        @if($vehicle->is_company_managed && $vehicle->base_daily_rate)
                                            <div class="text-xs text-gray-500">
                                                Base: {{ number_format($vehicle->base_daily_rate, 0) }}
                                                <span class="text-blue-600">({{ $vehicle->commission_percentage }}%)</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b">{{ $vehicle->city }}</td>
                                    <td class="py-3 px-4 border-b">
                                        @if($vehicle->is_company_managed && !$vehicle->is_approved)
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending Approval
                                            </span>
                                        @else
                                            <div x-data="{ 
                                                                status: '{{ $vehicle->status }}', 
                                                                date: '{{ $vehicle->available_from_date?->format('Y-m-d') ?? '' }}',
                                                                showDatePicker: {{ $vehicle->status === 'available_from_date' ? 'true' : 'false' }}
                                                            }">
                                                <select x-model="status"
                                                    @change="showDatePicker = (status === 'available_from_date'); if (status !== 'available_from_date') { $wire.updateStatus({{ $vehicle->id }}, status) }"
                                                    class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="available">Available</option>
                                                    <option value="booked">Booked</option>
                                                    <option value="maintenance">Maintenance</option>
                                                    <option value="available_from_date">Available on Date</option>
                                                </select>

                                                <div x-show="showDatePicker" class="mt-2" style="display: none;">
                                                    <input type="date" x-model="date"
                                                        @change="$wire.updateStatus({{ $vehicle->id }}, 'available_from_date', date)"
                                                        class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md w-full">
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b">
                                        <div class="flex flex-col space-y-2">
                                            @if($vehicle->is_company_managed && !$vehicle->is_approved)
                                                <div x-data="{ commission: {{ $vehicle->commission_percentage }} }"
                                                    class="mb-2">
                                                    <label class="text-xs text-gray-600">Commission %:</label>
                                                    <div class="flex gap-1">
                                                        <input type="number" x-model="commission" step="0.5" min="0" max="50"
                                                            class="text-xs border-gray-300 rounded px-2 py-1 w-16">
                                                        <button @click="$wire.updateCommission({{ $vehicle->id }}, commission)"
                                                            class="text-xs bg-gray-500 text-white px-2 py-1 rounded hover:bg-gray-600">
                                                            Set
                                                        </button>
                                                    </div>
                                                </div>
                                                <button wire:click="approve({{ $vehicle->id }})"
                                                    class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 font-semibold">
                                                    ✓ Approve
                                                </button>
                                            @endif

                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-medium text-sm">Edit</a>
                                                <button wire:click="delete({{ $vehicle->id }})"
                                                    wire:confirm="Are you sure you want to delete this vehicle?"
                                                    class="text-red-600 hover:text-red-900 font-medium text-sm">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                            <p class="text-lg font-medium">No public vehicles found.</p>
                                            <p class="text-sm">Start by adding a vehicle to the public fleet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>