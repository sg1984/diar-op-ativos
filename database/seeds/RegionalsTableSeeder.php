<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regionals')->insert(
            [
                'name' => 'Leste',
                'description' => 'Leste',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('regionals')->insert(
            [
                'name' => 'Oeste',
                'description' => 'Oeste',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('regionals')->insert(
            [
                'name' => 'Sul',
                'description' => 'Sul',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
    }
}
