<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company_map_arr = [
            'bevi.com.ph'           => 'BEVI',
            'beviasiapacific.com'   => 'BEVA',
            'bevmi.com'             => 'BEVM',
            'kojiesan.com'          => 'BEVI',
            'onestandpoint.com'     => 'OSP',
            'spcmicrotech.com'      => 'SPC',
            'thepbb.com'            => 'PBB',
        ];

        $location_map_arr = [
            'BEVI' => 'BEVI Aranga',
            'BEVA' => 'BEVI Batangas',
            'BEVM' => 'BEVMI San Pablo',
            'OSP'  => 'OSP San Pablo',
            'SPC'  => 'BEVMI San Pablo',
            'PBB'  => 'BEVMI San Pablo',
        ];

        $user = new User([
            'company_id' => Company::first()->id,
            'name' => 'Administrator',
            'email' => 'admin@admin',
            'password' => Hash::make('p4ssw0rd'),
        ]);
        $user->save();

        $user->assignRole('superadmin');

        $path = public_path('assets/UsersData.json');
        if (!File::exists($path)) {
            abort(404, "File not found.");
        }
        $usersData = File::json($path);

        foreach($usersData['users'] as $userData) {
            $name = $userData['First Name [Required]'].' '.$userData['Last Name [Required]'];
            $email = $userData['Email Address [Required]'];

            // extract domain from email
            $email_parts = explode('@', $email);
            $username = reset($email_parts);
            $domain = end($email_parts);

            $password = Hash::make($username.'123!');
            $company = Company::where('name', $company_map_arr[$domain] ?? '')->first();
            $location = Location::where('location_name', $location_map_arr[$company->name ?? NULL] ?? '')->first();

            $user = new User([
                'company_id' => $company->id ?? NULL,
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
            $user->save();

            $user->locations()->attach($location->id ?? NULL);

            $user->assignRole('user');
        }
    }
}
