<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
                ->insert([
                    'name' =>'Admin',
                    'email' => 'pbpf_kelompokd@admin.com',
                    'password' => '$2b$10$LoFpn/b4cj1MvWGm6Sv23ex1J69Z.Y233iiQqVh6t.r01b04Cr.qa',//pbpd123
                    'country' => 'indonesia',
                    'city' => 'yogya',
                    'phone' => '09738234',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ]);
    }
}
