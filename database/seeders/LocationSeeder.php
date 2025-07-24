<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations_arr = [
            [
                'location_name' => 'BEVI Aranga',
                'address' => '9002-1 Aranga, Makati, Metro Manila'
            ],
            [
                'location_name' => 'BEVI Batangas',
                'address' => '1262 Batangas st, corner Honduras, Makati City, 1234 Metro Manila'
            ],
            [
                'location_name' => 'BEVMI San Pablo',
                'address' => '618 Alvarez St., San Pablo City, 4000 Laguna'
            ],
            [
                'location_name' => 'OSP San Pablo',
                'address' => 'Lipa - Alaminos Rd, Alaminos, Laguna'
            ]
        ];

        foreach($locations_arr as $location) {
            $location = new Location([
                'location_name' => $location['location_name'],
                'address' => $location['address']
            ]);
            $location->save();
        }
    }
}
