<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'MarkJC',
            'email' => 'markjc@mweb.co.za',
            'password' => Hash::make('Password123'),
            'token' => '',
        ]);
    }
}
