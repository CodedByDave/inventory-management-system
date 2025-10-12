<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'employee_id'   => 'EMP' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),

            'name'          => 'Dave Tester',
            'email'         => 'davemagno2314@gmail.com',
            'phone'         => '1234567890',
            'address'       => '123 Test St, Test City',
            'gender'        => 'Male',
            'date_of_birth' => '1990-01-01',

            'role'          => 'admin',
            'status'        => 'active',

            'date_hired'    => '2020-01-01',
            'photo'         => null,

            'password'      => Hash::make('password'),

            // rememberToken is auto-managed, no need to insert

            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        DB::table('users')->insert([
            'employee_id'   => 'EMP' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),

            'name'          => 'Staff Tester',
            'email'         => 'davemagno3011@gmail.com',
            'phone'         => '1234567890',
            'address'       => '123 Test St, Test City',
            'gender'        => 'Male',
            'date_of_birth' => '1990-01-01',

            'role'          => 'staff',
            'status'        => 'active',

            'date_hired'    => '2020-01-01',
            'photo'         => null,

            'password'      => Hash::make('password'),

            // rememberToken is auto-managed, no need to insert

            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
