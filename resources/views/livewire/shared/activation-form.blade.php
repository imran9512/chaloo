<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-xl font-bold mb-4">Account Activation Required</h3>
        <p class="mb-6 text-gray-600 dark:text-gray-400">
            To activate your account and start using Chaloo, please upload your ID Card and Driving License.
            Our team will review your documents and approve your account shortly.
        </p>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- ID Card Upload -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Front -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                        ID Card (Front)
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="file" wire:model="id_card" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                        " />
                        <label
                            class="cursor-pointer bg-green-600 text-white p-2 rounded-full shadow hover:bg-green-700 flex-shrink-0"
                            title="Take Photo">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            <input type="file" wire:model="id_card" accept="image/*" capture="environment"
                                class="hidden" />
                        </label>
                    </div>
                    @error('id_card') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($id_card)
                        <div class="mt-2">
                            <x-lightbox-image :src="$id_card->temporaryUrl()" alt="ID Card Front" />
                        </div>
                    @endif
                </div>

                <!-- Back -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                        ID Card (Back)
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="file" wire:model="id_card_back" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                        " />
                        <label
                            class="cursor-pointer bg-green-600 text-white p-2 rounded-full shadow hover:bg-green-700 flex-shrink-0"
                            title="Take Photo">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            <input type="file" wire:model="id_card_back" accept="image/*" capture="environment"
                                class="hidden" />
                        </label>
                    </div>
                    @error('id_card_back') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($id_card_back)
                        <div class="mt-2">
                            <x-lightbox-image :src="$id_card_back->temporaryUrl()" alt="ID Card Back" />
                        </div>
                    @endif
                </div>
            </div>

            <!-- License Upload -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Front -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                        Driving License (Front)
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="file" wire:model="license" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                        " />
                        <label
                            class="cursor-pointer bg-green-600 text-white p-2 rounded-full shadow hover:bg-green-700 flex-shrink-0"
                            title="Take Photo">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            <input type="file" wire:model="license" accept="image/*" capture="environment"
                                class="hidden" />
                        </label>
                    </div>
                    @error('license') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($license)
                        <div class="mt-2">
                            <x-lightbox-image :src="$license->temporaryUrl()" alt="License Front" />
                        </div>
                    @endif
                </div>

                <!-- Back -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                        Driving License (Back)
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="file" wire:model="license_back" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                        " />
                        <label
                            class="cursor-pointer bg-green-600 text-white p-2 rounded-full shadow hover:bg-green-700 flex-shrink-0"
                            title="Take Photo">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            <input type="file" wire:model="license_back" accept="image/*" capture="environment"
                                class="hidden" />
                        </label>
                    </div>
                    @error('license_back') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($license_back)
                        <div class="mt-2">
                            <x-lightbox-image :src="$license_back->temporaryUrl()" alt="License Back" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Submit for Approval</span>
                    <span wire:loading>Submitting...</span>
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500">
                Need help? Contact us on WhatsApp:
                <a href="https://wa.me/1234567890" target="_blank" class="text-green-600 font-bold hover:underline">
                    +1 234 567 890
                </a>
            </p>
        </div>
    </div>
</div>