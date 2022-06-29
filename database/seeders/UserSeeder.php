<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('1234567890');
        $admin->salt = bcrypt('1234567890');
        $admin->reset_token = bcrypt('1234567890');
        $admin->api_token = 'APH562OB05pE9ooYqwBuDiZI8wIpui1Wz0PMLg9d27VSN2Go5YPKj0Jhmfs5';
        $admin->status = '1';
        $admin->role_id = '1';
        $admin->save();
    }
}
