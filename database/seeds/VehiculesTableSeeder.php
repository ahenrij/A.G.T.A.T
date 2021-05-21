<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VehiculesTableSeeder extends Seeder
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
        DB::table('vehicules')->delete();

        for ($i = 1; $i <= 10; $i++) {

            $date = $this->randDate();

            DB::table('vehicules')->insert([
                'immatriculation' => 'AB 0' . $i . '45' . ($i + 1) . ' RB',
                'marque' => 'Marque' . $i,
                'type_vehicule_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
