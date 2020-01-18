<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubstationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('substations')->insert(
            [
                'name' => 'ACD',
                'description' => 'ACD',
                'regional_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('substations')->insert(
            [
                'name' => 'BGI',
                'description' => 'BGI',
                'regional_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('substations')->insert(
            [
                'name' => 'RLD',
                'description' => 'RLD',
                'regional_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('substations')->insert(
            [
                'name' => 'TSA',
                'description' => 'TSA',
                'regional_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('substations')->insert(
            [
                'name' => 'TSD',
                'description' => 'TSD',
                'regional_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('substations')->insert(
            [
                'name' => 'JDM',
                'description' => 'JDM',
                'regional_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
    }
}
