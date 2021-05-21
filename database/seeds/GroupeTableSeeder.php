<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GroupeTableSeeder extends Seeder
{
    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }

    public function run()
    {
        DB::table('groupes')->delete();

        DB::table('groupes')->insert([
            'libelle' => AUCUN_GROUPE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        for ($i = 1; $i < 5; ++$i) {
            $date = $this->randDate();
            DB::table('groupes')->insert([
                'libelle' => 'Groupe ' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}

?>