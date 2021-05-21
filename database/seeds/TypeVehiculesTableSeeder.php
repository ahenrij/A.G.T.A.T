<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TypeVehiculesTableSeeder extends Seeder
{
    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_vehicules')->delete();

        for($i=1;$i<=10;$i++){

            $date = $this->randDate();

            DB::table('type_vehicules')->insert([
                'libelle' => 'Type Véhicule'.$i,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
