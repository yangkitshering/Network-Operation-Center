<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataCenter;

class DCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Thimphu DC
        DataCenter::create([
            'dc_name' => 'Thimphu DC',
            'dc_location' => 'Thimphu, Chubachu'
        ]);

        //Phuntsholing DC
        DataCenter::create([
            'dc_name' => 'P/ling DC',
            'dc_location' => 'Phuntsholing'
        ]);

        //Jakar DC
        DataCenter::create([
            'dc_name' => 'Jakar DC',
            'dc_location' => 'Bumthang'
        ]);
    }
}
