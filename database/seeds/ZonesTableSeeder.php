<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ZonesTableSeeder extends Seeder
{
    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12 ), rand(1, 28));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->delete();

        $zones = array('Port de pêche', 'Capitainerie', 'Accès 1', 'Accès 2', 'Zone 1', 'Zone 2');

        for ($i = 0; $i < count($zones); $i++) {

            $date = $this->randDate();

            DB::table('zones')->insert([
                'libelle' => $zones[$i],
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
