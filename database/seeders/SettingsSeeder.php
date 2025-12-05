<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'whatsapp_registration', 'value' => '923001234567'],
            ['key' => 'whatsapp_guest_inquiry', 'value' => '923001234567'],
            ['key' => 'whatsapp_company_vehicles', 'value' => '923001234567'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
