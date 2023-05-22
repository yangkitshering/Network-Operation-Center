<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usr = User::create([
            'name' => 'Administrator',
            'empID' => '915',
            'email' => 'admin@bt.bt',
            'password' => Hash::make('12345678'),
        ]);
        $usr->attachRole('admin');
    }
}
