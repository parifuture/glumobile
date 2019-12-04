<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Processor;

class ProcessorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processors')->delete();

        DB::table('processors')->insert([
            'processor_id' => 'core_0'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_1'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_2'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_3'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_4'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_5'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_6'
        ]);
        DB::table('processors')->insert([
            'processor_id' => 'core_7'
        ]);
    }
}
