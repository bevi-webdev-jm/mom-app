<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([PermissionSeeder::class]);
        $this->call([RoleSeeder::class]);

        $this->call([CompanySeeder::class]);
        $this->call([LocationSeeder::class]);
        $this->call([UserSeeder::class]);

        $this->call([SystemSettingSeeder::class]);
    }
}
