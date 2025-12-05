<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ __("Welcome back, Admin!") }}</h3>
                    <div class="mt-4 space-x-4">
                        <a href="{{ route('admin.approvals') }}" class="text-blue-500 hover:underline font-bold">Pending Approvals</a> |
                        <a href="{{ route('admin.vehicle-types') }}" class="text-blue-500 hover:underline">Vehicle Types</a> |
                        <a href="{{ route('admin.users') }}" class="text-blue-500 hover:underline">Manage Users</a> |
                        <a href="{{ route('admin.packages') }}" class="text-blue-500 hover:underline">Packages</a> |
                        <a href="{{ route('admin.settings') }}" class="text-blue-500 hover:underline">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>