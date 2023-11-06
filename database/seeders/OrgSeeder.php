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
        //Thimphu DC client
        Organization::create([
            'org_name' => 'NPPF',
            'org_address' => 'Thimphu',
            'dc_id' => 1,
            'is_thim_dc' => 1
        ]);

        //Phuntsholing DC client
        Organization::create([
            'org_name' => 'NHDCL',
            'org_address' => 'Phuntsholing',
            'dc_id' => 2,
            'is_pling_dc' => 1
        ]);

        //Jakar DC client
        Organization::create([
            'org_name' => 'DITT',
            'org_address' => 'Bumthang',
            'dc_id' => 3,
            'is_jakar_dc' => 1
        ]);
    }
}
