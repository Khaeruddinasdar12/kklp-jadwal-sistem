<?php

use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departemens')->insert([
            'nama' => 'Keuangan',
        ]);

        DB::table('departemens')->insert([
            'nama' => 'Persuratan',
        ]);

        DB::table('departemens')->insert([
            'nama' => 'HRD',
        ]);
    }
}
