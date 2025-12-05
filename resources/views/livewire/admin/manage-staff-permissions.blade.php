<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Manage Permissions: {{ $user->name }}</h2>
                    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:underline">← Back to Users</a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded">
                    <p class="text-sm"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-sm"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                </div>

                <!-- Permission Template Selector -->
                <div class="mb-6 bg-blue-50 dark:bg-blue-900 p-4 rounded">
                    <h3 class="text-md font-semibold mb-3">Quick Apply Template</h3>
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <x-input-label for="template" :value="__('Select Permission Template')" />
                            <select wire:model="selectedTemplate" id="template"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Select a template --</option>
                                @foreach($permissionGroups as $key => $group)
                                    <option value="{{ $key }}">{{ $group['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button wire:click="applyTemplate" type="button" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Apply Template
                            </button>
                        </div>
                    </div>
                    <p class="text-xs text-blue-800 dark:text-blue-200 mt-2">
                        <strong>Note:</strong> Templates are starting points. You can customize permissions after applying a template.
                    </p>
                </div>

                <form wire:submit="updatePermissions">
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold mb-4">Select Permissions:</h3>
                        
                        @foreach($availablePermissions as $slug => $data)
                            <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                                <!-- Parent Permission -->
                                <div class="flex items-center mb-3">
                                    <input 
                                        type="checkbox" 
                                        wire:model="selectedPermissions" 
                                        value="{{ $slug }}" 
                                        id="perm_{{ $slug }}"
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <label for="perm_{{ $slug }}" class="ml-3 block text-base font-bold text-gray-900 dark:text-gray-100">
                                        {{ $data['label'] }}
                                    </label>
                                </div>

                                <!-- Child Permissions -->
                                @if(!empty($data['children']))
                                    <div class="ml-8 space-y-2 border-l-2 border-gray-200 dark:border-gray-600 pl-4">
                                        @foreach($data['children'] as $childSlug => $childLabel)
                                            <div class="flex items-center">
                                                <input 
                                                    type="checkbox" 
                                                    wire:model="selectedPermissions" 
                                                    value="{{ $childSlug }}" 
                                                    id="perm_{{ $childSlug }}"
                                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <label for="perm_{{ $childSlug }}" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $childLabel }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 bg-yellow-50 dark:bg-yellow-900 p-4 rounded">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <strong>Note:</strong> 
                            <br>• Checking a parent permission grants all child permissions automatically.
                            <br>• Edit permission automatically includes view permission.
                            <br>• Admin users have all permissions by default.
                        </p>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>