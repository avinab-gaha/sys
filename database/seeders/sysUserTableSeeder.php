<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\SysUser;

class sysUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $password = Hash::make('12345');
        $adminRecords = [
            [
                'id' => 1,
                'username' => 'admin',
                'phone' => 9810100101,
                'email' => 'admin@email.com',
                'password' => $password,
                'profile_image' => '',
                'status' => 1,
                'postal_code' => '+977',
                'address1' => 'kalimati',
                'language' => 'english',
                'join_date' => '2024-01-05 10:40:55',

            ],
        ];
        SysUser::insert($adminRecords);
    }
}
