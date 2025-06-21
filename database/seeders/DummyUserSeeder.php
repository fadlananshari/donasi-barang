<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'email'=>'admin@gmail.com',
                'password'=>bcrypt('123456'),
                'role'=>'admin'
            ],
            [
                'email'=>'donatur@gmail.com',
                'password'=>bcrypt('123456'),
                'role'=>'donatur'
            ],
            [
                'email'=>'penerima@gmail.com',
                'password'=>bcrypt('123456'),
                'role'=>'penerima'
            ]
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }

        $profileData = [
            [
                'id_user' => 1,
                'name' => 'Admin',
                'phone_number' => '8123456789',
                'address' => 'Jl. Raya No. 1',
                'category' => 'admin'
            ],
            [
                'id_user' => 2,
                'name' => 'Donatur',
                'phone_number' => '8123456789',
                'address' => 'Jl. Raya No. 2',
                'category' => 'donatur'
            ],[
                'id_user' => 3,
                'name' => 'Penerima',
                'phone_number' => '8123456789',
                'address' => 'Jl. Raya No.3',
                'category' => 'penerima'
            ],
        ];
        foreach($profileData as $key => $val){
            Profile::create($val);
        }

    }
}
