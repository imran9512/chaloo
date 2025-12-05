<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@chaloo.com')->first();

        if ($user) {
            $user->password = Hash::make('admin123');
            $user->save();
            $this->command->info('Password reset successfully for admin@chaloo.com to admin123');
        } else {
            $this->command->error('User admin@chaloo.com not found');
        }
    }
}
