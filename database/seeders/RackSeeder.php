<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RackList;

class RackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rackList = [
            [
                'rack_no' => 'Rack-1',
                'rack_name' => 'ERPNext Server rack',
                'desc' => 'this is description',
                'org_id' => 3
            ],
            [
                'rack_no' => 'Rack-2',
                'rack_name' => 'NOC Server rack',
                'desc' => 'this is description',
                'org_id' => 1,
            ],
            [
                'rack_no' => 'Rack-3',
                'rack_name' => 'NPPF Server rack',
                'desc' => 'this is description',
                'org_id' => 2
            ],
            [
                'rack_no' => 'Rack-4',
                'rack_name' => 'Bhutan Telecom Server rack',
                'desc' => 'this is description',
                'org_id' => 3
            ],
            [
                'rack_no' => 'Rack-5',
                'rack_name' => 'Druk REN Server rack',
                'desc' => 'this is description',
                'org_id' => 1
            ],
            ];

            RackList::insert($rackList);
    }
}
