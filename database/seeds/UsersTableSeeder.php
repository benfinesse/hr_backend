<?php

use App\Models\Admin;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    use Utility;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $uuid = $this->makeUuid();
        $user = [
            'email' => 'admin@app.com',
            'uuid'=>$uuid,
            'first_name'=>"Super",
            'last_name'=>"Admin",
            'phone'=>"08000000000",
            'active'=>true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ];

        Admin::create($user);

        $banks = [
            'GUARANTEE TRUST BANK',
            'ZENITH BANK',
            'UBA',
            'FIRST BANK',
            'POLARIS BANK',
            'WEMA BANK',
            'DIAMOND ACCESS BANK',
        ];
        $gender = ['M','F'];


        $start = 100;
        while ($start > 0){
            factory(User::class, 1)->create(
                [
                    'bank' => $banks[rand(0,6)],
                    'gender' => $gender[rand(0,1)],
                    'token' => $this->randomName(36),
                    'u_token_exp' => time()+172800
                ]
            );
            $start--;
        }


    }
}
