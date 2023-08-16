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
        $dc_List = [
            [
                'dc_name' => 'Thimphu DC',
                'dc_location' => 'Thimphu'
            ],
            [
                'dc_name' => 'P/ling DC',
                'dc_location' => 'Phuntsholing'
            ],
            [
                'dc_name' => 'Jakar DC',
                'dc_location' => 'Bumthang'
            ],
            ];

            DataCenter::insert($dc_List);
    }
}
