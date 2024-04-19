<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User\User::create([
            'first_name'    =>  'Super',
            'second_name'   =>  '',
            'surname'       =>  'Admin',
            'email'         =>  'superadmin@wrp.com',
            'password'      =>  \Illuminate\Support\Facades\Hash::make('111111'),
            'verify'        =>  true,
        ]);
        $user->assignRole('superadmin');
    }
}
