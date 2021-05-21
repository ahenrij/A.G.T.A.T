<?php

use Illuminate\Database\Seeder;

class TypeUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('type_users')->delete();

        $type_users = array(USAGER_LABEL, CAISSIER_LABEL, AGENT_LABEL, DISTRIBUTEUR_LABEL, CHAUFFEUR_LABEL, ADMIN_LABEL);

        for ($i = 0; $i < 6; ++$i) {
            DB::table('type_users')->insert([
                'libelle' => $type_users[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}

?>