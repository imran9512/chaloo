<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('My Vehicles') }}</h2>
                    <a href="{{ route('transporter.vehicles.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Vehicle
                    </a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Name</th>
                                <th class="py-2 px-4 border-b text-left">Type</th>
                                <th class="py-2 px-4 border-b text-left">Reg. Number</th>
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
                                    <td class="py-2 px-4 border-b">{{ $vehicle->registration_number ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">PKR {{ number_format($vehicle->daily_rate, 0) }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <div x-data="{ 
                                                status: '{{ $vehicle->status }}', 
                                                date: '{{ $vehicle->available_from_date?->format('Y-m-d') ?? '' }}',
                                                showDatePicker: {{ $vehicle->status === 'available_from_date' ? 'true' : 'false' }}
                                            }">
                                            <select x-model="status"
                                                @change="showDatePicker = (status === 'available_from_date'); if (status !== 'available_from_date') { $wire.updateStatus({{ $vehicle->id }}, status) }"
                                                class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                                <option value="available">Available</option>
                                                <option value="booked">Booked</option>
                                                <option value="available_from_date">Available on Date</option>
                                            </select>

                                            <div x-show="showDatePicker" class="mt-2">
                                                <input type="date" x-model="date"
                                                    @change="$wire.updateStatus({{ $vehicle->id }}, 'available_from_date', date)"
                                                    class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                                <div x-show="date" class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                    Available: <span
                                                        x-text="new Date(date).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('transporter.vehicles.edit', $vehicle->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <button wire:click="delete({{ $vehicle->id }})"
                                            wire:confirm="Are you sure you want to delete this vehicle?"
                                            class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">No vehicles found.</td>
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