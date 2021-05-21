<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TitreTableSeeder extends Seeder
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
        DB::table('titres')->delete();

        $etat = array('N', 'V');
        $distributeur_id = getIdTypeUser(DISTRIBUTEUR_LABEL);
        $users_id = \App\User::where('type_user_id', $distributeur_id)->pluck('id')->toArray();
        $pieces = pieceJustificatifs();

        for ($i = 1; $i <= 10; $i++) {

            $id = rand(1,10);
            $type_titre_id = (DB::table('vehicules')->where('user_id',$id)->first()) ? rand(3,4) : rand(1,2);
            $date = $this->randDate();

            DB::table('titres')->insert([
                'numero' => rand(1000, 9999),
                'duree' => 24 * $i,
                'date_delivrance' => date('Y-m-d H:i:s'),
                'demande' => rand(0,1),
                'etat' => $etat[rand(0, 1)],
                'cout' => 1500 * $i,
                'piece' => array_rand($pieces),
                'zone_id' => rand(1, 6),
                'type_titre_id' => $type_titre_id,
                'agent_id' => $users_id[array_rand($users_id)],
                'usager_id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
