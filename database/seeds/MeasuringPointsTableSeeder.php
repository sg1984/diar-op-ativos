<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasuringPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Regional Leste
        // Subestação ACD
        DB::table('measuring_points')->insert(
            [
                'name' => 'ACD.EL03C2',
                'description' => 'ACD.EL03C2',
                'substation_id' => 1,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'ACD.EL03C4',
                'description' => 'ACD.EL03C4',
                'substation_id' => 1,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'ACD.EL04S1',
                'description' => 'ACD.EL04S1',
                'substation_id' => 1,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'ACD.EL04S1',
                'description' => 'ACD.EL04S1',
                'substation_id' => 1,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'CD.TR04T6',
                'description' => 'CD.TR04T6',
                'substation_id' => 1,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

        // Subestação BGI
        DB::table('measuring_points')->insert(
            [
                'name' => 'BGI.EL04C1',
                'description' => 'BGI.EL04C1',
                'substation_id' => 2,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'PEBGI-04C1-01P',
                'description' => 'PEBGI-04C1-01P',
                'substation_id' => 2,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'PEBGI-04C1-01R',
                'description' => 'PEBGI-04C1-01R',
                'substation_id' => 2,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

        // Subestação RLD
        DB::table('measuring_points')->insert(
            [
                'name' => 'RLD.EL04S2',
                'description' => 'RLD.EL04S2',
                'substation_id' => 3,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

        // Regional Oeste
        // Subestação TSA
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.EL02J4',
                'description' => 'TSA.EL02J4',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.EL02J6',
                'description' => 'TSA.EL02J6',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.EL02J9',
                'description' => 'TSA.EL02J9',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.EL04F1',
                'description' => 'TSA.EL04F1',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.EL04L3',
                'description' => 'TSA.EL04L3',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSA.TR04T4_69kV',
                'description' => 'TSA.TR04T4_69kV',
                'substation_id' => 4,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'PITSA-04F1-01P',
                'description' => 'PITSA-04F1-01P',
                'substation_id' => 4,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'PITSA-04F1-01R',
                'description' => 'PITSA-04F1-01R',
                'substation_id' => 4,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

        // Subestação TSD
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSD.EL04L4',
                'description' => 'TSD.EL04L4',
                'substation_id' => 5,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSD.EL05C8',
                'description' => 'TSD.EL05C8',
                'substation_id' => 5,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSD.EL05C9',
                'description' => 'TSD.EL05C9',
                'substation_id' => 5,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSD.TR04T3_CS',
                'description' => 'TSD.TR04T3_CS',
                'substation_id' => 5,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'TSD.TR05T2_230kV',
                'description' => 'TSD.TR05T2_230kV',
                'substation_id' => 5,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

        // Regional Sul
        // Subestação JDM
        DB::table('measuring_points')->insert(
            [
                'name' => 'SEJDM-04F1-01P',
                'description' => 'SEJDM-04F1-01P',
                'substation_id' => 6,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'SEJDM-04F1-01R',
                'description' => 'SEJDM-04F1-01R',
                'substation_id' => 6,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'SEJDM-04F3-17P',
                'description' => 'SEJDM-04F3-17P',
                'substation_id' => 6,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'SEJDM-04F3-17R',
                'description' => 'SEJDM-04F3-17R',
                'substation_id' => 6,
                'system' => 'Faturamento',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'JDM.EL04F1_F',
                'description' => 'JDM.EL04F1_F',
                'substation_id' => 6,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'JDM.EL04F2',
                'description' => 'JDM.EL04F2',
                'substation_id' => 6,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'JDM.EL04F3',
                'description' => 'JDM.EL04F3',
                'substation_id' => 6,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'JDM.EL05V5',
                'description' => 'JDM.EL05V5',
                'substation_id' => 6,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );
        DB::table('measuring_points')->insert(
            [
                'name' => 'JDM.TR04T2_69kV',
                'description' => 'JDM.TR04T2_69kV',
                'substation_id' => 6,
                'system' => 'Qualimetria',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );


    }
}
