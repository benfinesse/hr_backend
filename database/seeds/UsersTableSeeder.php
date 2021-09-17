<?php

use App\Models\Admin;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


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
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];

        Admin::create($user);

        factory(User::class, 100)->create();
    }
}
