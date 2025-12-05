<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('My Tours') }}</h2>
                    <a href="{{ route('agent.tours.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Tour
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
                                <th class="py-2 px-4 border-b text-left">Destination</th>
                                <th class="py-2 px-4 border-b text-left">Duration</th>
                                <th class="py-2 px-4 border-b text-left">Price (Person/Couple)</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                                <th class="py-2 px-4 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tours as $tour)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4 border-b font-medium">{{ $tour->name }}</td>
                                    <td class="py-2 px-4 border-b">
                                        {{ $tour->main_destination }}
                                        @if(count($tour->destinations ?? []) > 1)
                                            <span class="text-xs text-gray-500">(+{{ count($tour->destinations) - 1 }} more)</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="text-sm">
                                            <div>🛫 {{ $tour->departure_date->format('d M Y') }}</div>
                                            @if($tour->arrival_date)
                                                <div>🛬 {{ $tour->arrival_date->format('d M Y') }}</div>
                                            @endif
                                            <div class="text-xs text-gray-500">{{ $tour->duration_days }} Days</div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="text-sm">
                                            <div>👤 {{ number_format($tour->price_per_person) }}</div>
                                            @if($tour->price_per_couple)
                                                <div class="text-xs text-gray-500">👥 {{ number_format($tour->price_per_couple) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <select wire:change="updateStatus({{ $tour->id }}, $event.target.value)" 
                                            class="text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1 pl-2 pr-6
                                            {{ $tour->status === 'booking_on' ? 'bg-green-50 text-green-800 border-green-200' : ($tour->status === 'booking_off' ? 'bg-yellow-50 text-yellow-800 border-yellow-200' : 'bg-gray-50 text-gray-800 border-gray-200') }}">
                                            <option value="booking_on" {{ $tour->status === 'booking_on' ? 'selected' : '' }}>Booking ON</option>
                                            <option value="booking_off" {{ $tour->status === 'booking_off' ? 'selected' : '' }}>Booking OFF</option>
                                            <option value="deactivated" {{ $tour->status === 'deactivated' ? 'selected' : '' }}>Deactivate</option>
                                        </select>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('agent.tours.edit', $tour->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <button wire:click="delete({{ $tour->id }})" wire:confirm="Are you sure you want to delete this tour?" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">No tours found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $tours->links() }}
                </div>
            </div>
        </div>
    </div>
</div>