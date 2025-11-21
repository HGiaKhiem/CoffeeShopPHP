<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@example.com';

        // Nếu đã tồn tại user admin thì cập nhật role
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update(['role' => 'admin']);
        } else {
            User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => Hash::make('password'), 
                'role' => 'admin',
            ]);
        }
    }
}
