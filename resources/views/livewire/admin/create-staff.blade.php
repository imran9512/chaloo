<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Create Staff Member</h2>
                    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:underline">← Back to Users</a>
                </div>

                <form wire:submit="createStaff">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name *')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email *')" />
                            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email"
                                required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password *')" />
                            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password"
                                required />
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters. Staff can change this later.</p>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
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
                    </div>

                    <div class="mt-6 bg-blue-50 dark:bg-blue-900 p-4 rounded">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> Staff members are created with 'operator' role and 'active' status.
                            You can assign permissions after creation from the Manage Users page.
                        </p>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Staff Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>