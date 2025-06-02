<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = new User([
            'name' => 'Administrator',
            'email' => 'admin@admin',
            'password' => Hash::make('p4ssw0rd'),
        ]);
        $user->save();

        $user->assignRole('superadmin');

        $users_arr = [
            [
                'name' => 'Tym Jimenez',
                'email' => 'tym.jimenez@kojiesan.com',
                'password' => 'tym.jimenez123!',
            ],
            [
                'name' => 'Christian Ampong',
                'email' => 'christian.ampong@beviasiapacific.com',
                'password' => 'christian.ampong123!',
            ],
            [
                'name' => 'Jemmil Seva',
                'email' => 'jun.matos@kojiesan.com',
                'password' => 'jun.matos123!', 
            ],
            [
                'name' => 'Jun Matos',
                'email' => 'jem.seva@beviasiapacific.com',
                'password' => 'jem.seva123!',
            ],
            [
                'name' => 'Michael Angelo Reyes',
                'email' => 'toots.reyes@kojiesan.com',
                'password' => 'toots.reyes123!',
            ],
            [
                'name' => 'Tricia Gregorio',
                'email' => 'veronica.gregorio@kojiesan.com',
                'password' => 'veronica.gregorio123!',
            ],
            [
                'name' => 'Dranreb Menguito',
                'email' => 'dranreb.menguito@kojiesan.com',
                'password' => 'dranreb.menguito123!',
            ],
            [
                'name' => 'Nikki Filio',
                'email' => 'nikki.filio@kojiesan.com',
                'password' => 'nikki.filio123!',
            ],
            [
                'name' => 'Ephraim Daguno',
                'email' => 'ephraim.daguno@kojiesan.com',
                'password' => 'ephraim.daguno123!',
            ],
            [
                'name' => 'Jean Iglesias',
                'email' => 'jean.iglesias@kojiesan.com',
                'password' => 'jean.iglesias123!',
            ],
        ];

        foreach($users_arr as $user_data) {
            $user = new User([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => Hash::make($user_data['password']),
            ]);
            $user->save();

            $user->assignRole('superadmin');
        }
    }
}
