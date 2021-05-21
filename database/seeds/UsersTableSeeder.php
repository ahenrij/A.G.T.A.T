<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{

    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }

    public function run()
    {
        DB::table('users')->delete();


        for($i = 0; $i < 9; ++$i)
        {
            $date = $this->randDate();
            DB::table('users')->insert([
                'nom' => 'Nom' . $i,
                'prenom' => 'Prenom' . $i,
                'fonction' => 'Fonction ' . $i,
                'telephone' => '012345678' . $i,
                'adresse' => 'Adresse ' . $i . ', Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam',
                'login' => 'uname' . $i,
                'password' => bcrypt('password' . $i),
                'profil' => 'man-'.rand(1, 10).'.png',
                'structure_id' => rand(1, 4),
                'type_user_id' => rand(1, 6),
                'groupe_id' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }

        DB::table('users')->insert([
            'nom' => AUCUN_DISTRIBUTEUR,
            'prenom' => '',
            'fonction' => '-',
            'telephone' => '-',
            'adresse' => '-',
            'login' => '-',
            'password' => bcrypt('password'),
            'profil' => 'man-'.rand(1, 10).'.png',
            'structure_id' => 1,
            'type_user_id' => 1,
            'groupe_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}

?>