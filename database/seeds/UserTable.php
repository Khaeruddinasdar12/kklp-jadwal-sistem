<?php

use Illuminate\Database\Seeder;

class UserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt(12345678),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
        ]);

        DB::table('users')->insert([
            'name' => 'Khaeruddin Asdar',
            'email' => 'khaeruddinasdar12@gmail.com',
            'password' => bcrypt(12345678),
        ]);
    }
}
