<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TypeTitresTableSeeder extends Seeder
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
        DB::table('type_titres')->delete();

        $durees = array('Journalier' => 24, 'Hebdomadaire' => 168);
        $types = array('Badge', 'Macaron');
        $code_type = array('BT', 'MT');

        $i = -1;
        foreach ($types as $type) {
            $i++;
            foreach ($durees as $label => $duree) {

                $date = $this->randDate();

                DB::table('type_titres')->insert([
                    'code' => $code_type[$i],
                    'libelle' => $type . ' ' . $label,
                    'duree' => $duree,
                    'prix' => 1500 * rand(1, 3),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
