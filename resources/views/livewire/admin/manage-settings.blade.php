<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold mb-6">WhatsApp Settings</h2>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="save">
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="whatsapp_transporter" :value="__('Transporter Package Payments')" />
                            <x-text-input wire:model="whatsapp_transporter" id="whatsapp_transporter"
                                class="block mt-1 w-full" type="text" placeholder="+92XXXXXXXXXX" />
                            <p class="text-sm text-gray-500 mt-1">WhatsApp number for transporter package payments</p>
                        </div>

                        <div>
                            <x-input-label for="whatsapp_agent" :value="__('Agent Package Payments')" />
                            <x-text-input wire:model="whatsapp_agent" id="whatsapp_agent" class="block mt-1 w-full"
                                type="text" placeholder="+92XXXXXXXXXX" />
                            <p class="text-sm text-gray-500 mt-1">WhatsApp number for agent package payments</p>
                        </div>

                        <div>
                            <x-input-label for="whatsapp_contact" :value="__('Contact Us / General Inquiries')" />
                            <x-text-input wire:model="whatsapp_contact" id="whatsapp_contact" class="block mt-1 w-full"
                                type="text" placeholder="+92XXXXXXXXXX" />
                            <p class="text-sm text-gray-500 mt-1">WhatsApp number for website contact us page</p>
                        </div>

                        <div>
                            <x-input-label for="whatsapp_vehicle_inquiry" :value="__('Vehicle Rental Inquiries (Guests)')" />
                            <x-text-input wire:model="whatsapp_vehicle_inquiry" id="whatsapp_vehicle_inquiry"
                                class="block mt-1 w-full" type="text" placeholder="+92XXXXXXXXXX" />
                            <p class="text-sm text-gray-500 mt-1">WhatsApp number for guest vehicle rental inquiries</p>
                        </div>

                        <div>
                            <x-input-label for="whatsapp_tour_inquiry" :value="__('Tour Booking Inquiries (Guests)')" />
                            <x-text-input wire:model="whatsapp_tour_inquiry" id="whatsapp_tour_inquiry"
                                class="block mt-1 w-full" type="text" placeholder="+92XXXXXXXXXX" />
                            <p class="text-sm text-gray-500 mt-1">WhatsApp number for guest tour booking inquiries</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>