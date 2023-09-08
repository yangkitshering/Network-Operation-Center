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
        //Thimphu DC Admin
        $admin_thimphu_dc = User::create([
            'name' => 'Admin(Thimphu DC)',
            'cid' => '11000000011',
            'organization' => 1,
            'dc_id' => 1,
            'email' => 'noc@bt.bt',
            'contact' => '17123410',
            'password' => Hash::make('admin@123'),
            'verified' => 1,
            'user_ref_id' => 0,
            'status' => 'A',
            'is_dcfocal' => 0
        ]);
        $admin_thimphu_dc->attachRole('admin');

        //Phuntsholing DC Admin
        $admin_pling_dc = User::create([
            'name' => 'Admin(P/ling DC)',
            'cid' => '11000000011',
            'organization' => 2,
            'dc_id' => 2,
            'email' => 'numo@bt.bt',
            'contact' => '17955641',
            'password' => Hash::make('admin@123'),
            'verified' => 1,
            'user_ref_id' => 0,
            'status' => 'A',
            'is_dcfocal' => 0
        ]);
        $admin_pling_dc->attachRole('admin');

        //Jakar DC Admin
        $admin_jakar_dc = User::create([
            'name' => 'Admin(Jakar DC)',
            'cid' => '11000000011',
            'organization' => 3,
            'dc_id' => 3,
            'email' => 'komal.sundas@bt.bt',
            'contact' => '17171572',
            'password' => Hash::make('admin@123'),
            'verified' => 1,
            'user_ref_id' => 0,
            'status' => 'A',
            'is_dcfocal' => 0
        ]);
        $admin_jakar_dc->attachRole('admin');
    }
}
