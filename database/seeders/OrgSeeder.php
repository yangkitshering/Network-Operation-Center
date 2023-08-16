<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dc_List = [
            [
                'org_name' => 'Druk REN',
                'org_address' => 'Thimphu',
                'dc_id' => 1
            ],
            [
                'org_name' => 'NPPF',
                'org_address' => 'Thimphu',
                'dc_id' => 1
            ],
            [
                'org_name' => 'Safe City Project',
                'org_address' => 'Thimphu',
                'dc_id' => 1  
            ],
            [
                'org_name' => 'NGN',
                'org_address' => 'Phuntsholing',
                'dc_id' => 2
            ],
            ];

            Organization::insert($dc_List);
    }
}
