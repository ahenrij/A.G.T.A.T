<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StructureTableSeeder extends Seeder
{
    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }

    public function run()
    {
        DB::table('structures')->delete();

        $raisonSociale = array('GROUPE BOLLORE', 'COMAN', 'SMTC', 'SOBEMAP','MAESRK');

        for ($i = 0; $i < count($raisonSociale); ++$i) {
            $date = $this->randDate();
            DB::table('structures')->insert([
                'raison_sociale' => $raisonSociale[$i],
                'contact' => '012345678' . $i,
                'adresse' => '04 BP 2526'.$i*2,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}

?>