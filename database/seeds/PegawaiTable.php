<?php

use Illuminate\Database\Seeder;

class PegawaiTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawais')->insert([
            'nip' => '19990408',
            'nama' => 'Jamal',
            'email' => 'jamal@gmail.com',
            'nohp' => '082344949505',
            'alamat' => 'Jln Paccerakkang',
            'departemen_id' => 1
        ]);

        DB::table('pegawais')->insert([
            'nip' => '19990412',
            'nama' => 'Rusdi',
            'email' => 'rusdi@gmail.com',
            'nohp' => '082344949505',
            'alamat' => 'Jln Paccerakkang',
            'departemen_id' => 2
        ]);

        DB::table('pegawais')->insert([
            'nip' => '19990400',
            'nama' => 'Rian',
            'email' => 'rian@gmail.com',
            'nohp' => '082344949505',
            'alamat' => 'Jln Paccerakkang',
            'departemen_id' => 3
        ]);

    }
}
