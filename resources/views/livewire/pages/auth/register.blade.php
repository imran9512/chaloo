<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $company_name = '';
    public string $email = '';
    public string $phone = '';
    public string $city = '';
    public string $role = 'transporter';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:' . User::class],
            'city' => ['required', 'string', 'max:100'],
            'role' => ['required', 'string', 'in:transporter,agent'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Set initial status based on role
        if (in_array($validated['role'], ['transporter', 'agent'])) {
            $validated['status'] = 'pending'; // Needs to upload documents
        } else {
            $validated['status'] = 'active';
        }

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        // Redirect to dashboard - it will show activation form if needed
        $this->redirect(route('dashboard', absolute: false), navigate: false);
    }
}; ?>

<div class="card p-4">
    <div class="text-center mb-6">
        <h4 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Create Account</h4>
    </div>

    <form wire:submit="register">
        <!-- Role Selection -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">I want to join
                as:</label>
            <select wire:model="role" id="role"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="transporter">Transporter (List Vehicles)</option>
                <option value="agent">Travel Agent (List Tours)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
            <input wire:model="name" id="name"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="name" placeholder="Enter your full name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Company Name -->
        <div class="mb-4">
            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company
                Name (Optional)</label>
            <input wire:model="company_name" id="company_name"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="company_name" placeholder="Your company name" autocomplete="organization" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
            <input wire:model="city" id="city"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="city" placeholder="Your city" required autocomplete="address-level2" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone
                Number</label>
            <input wire:model="phone" id="phone"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="phone" placeholder="Your phone number" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <input wire:model="email" id="email"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="email" name="email" placeholder="your@email.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
            <input wire:model="password" id="password"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password" name="password" placeholder="Create a password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation"
                class="block w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password" name="password_confirmation" placeholder="Confirm your password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-md shadow transition duration-150 ease-in-out mt-6">
            {{ __('Register') }}
        </button>

        <div class="text-center mt-4">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</div>