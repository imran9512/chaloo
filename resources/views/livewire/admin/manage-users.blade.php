<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Manage Users') }}</h2>
                    @if($activeTab === 'staff')
                        <a href="{{ route('admin.users.create-staff') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Staff Member
                        </a>
                    @endif
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

                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button wire:click="setTab('transporters')"
                            class="{{$activeTab === 'transporters' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Transporters
                        </button>
                        <button wire:click="setTab('agents')"
                            class="{{$activeTab === 'agents' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Agents
                        </button>
                        <button wire:click="setTab('staff')"
                            class="{{$activeTab === 'staff' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Staff / Operators
                        </button>
                    </nav>
                </div>

                <!-- Search -->
                <div class="mb-4">
                    <input wire:model.live="search" type="text" placeholder="Search by name, email, or phone..."
                        class="w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Name</th>
                                <th class="py-2 px-4 border-b text-left">Email</th>
                                <th class="py-2 px-4 border-b text-left">Phone</th>
                                <th class="py-2 px-4 border-b text-left">City</th>
                                @if($activeTab === 'transporters')
                                    <th class="py-2 px-4 border-b text-left">Company</th>
                                @endif
                                <th class="py-2 px-4 border-b text-left">Status</th>
                                <th class="py-2 px-4 border-b text-left">Registered</th>
                                <th class="py-2 px-4 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4 border-b font-medium">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->phone ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->city ?? '-' }}</td>
                                    @if($activeTab === 'transporters')
                                        <td class="py-2 px-4 border-b">{{ $user->company_name ?? '-' }}</td>
                                    @endif
                                    <td class="py-2 px-4 border-b">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : ($user->status === 'suspended' ? 'bg-orange-100 text-orange-800' : ($user->status === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($user->id !== auth()->id())
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                            @if($activeTab === 'staff')
                                                <a href="{{ route('admin.users.permissions', $user->id) }}"
                                                    class="text-purple-600 hover:text-purple-900 mr-2">Permissions</a>
                                            @endif
                                            @if(in_array($activeTab, ['transporters', 'agents']))
                                                <a href="{{ route('admin.users.assign-package', $user->id) }}"
                                                    class="text-green-600 hover:text-green-900 mr-2">Package</a>
                                            @endif
                                            @if($user->status === 'deleted')
                                                @if(auth()->user()->role === 'admin')
                                                    <button wire:click="permanentlyDeleteUser({{ $user->id }})"
                                                        wire:confirm="Are you sure you want to PERMANENTLY delete this user? This will remove all data and cannot be undone."
                                                        class="text-red-800 hover:text-red-900 font-bold">Permanent Delete</button>
                                                @endif
                                            @else
                                                @if($user->status === 'active')
                                                    <button wire:click="suspendUser({{ $user->id }})"
                                                        wire:confirm="Are you sure you want to suspend this user?"
                                                        class="text-orange-600 hover:text-orange-900 mr-2">Suspend</button>
                                                @else
                                                    <button wire:click="activateUser({{ $user->id }})"
                                                        class="text-green-600 hover:text-green-900 mr-2">Activate</button>
                                                @endif
                                                <button wire:click="deleteUser({{ $user->id }})"
                                                    wire:confirm="Are you sure? User will be marked as deleted but data will be preserved for reports."
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-sm italic">Your Account</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $activeTab === 'transporters' ? '8' : '7' }}"
                                        class="py-4 px-4 text-center text-gray-500">
                                        No {{ $activeTab }} found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>