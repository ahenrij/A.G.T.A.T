<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LogTableSeeder extends Seeder
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
        DB::table('logs')->delete();

        $type_logs = array(LOG_INFORMATION, LOG_MODIFICATION, LOG_SUPPRESSION);

        for ($i = 1; $i <= 10; $i++) {

            $date = $this->randDate();

            DB::table('logs')->insert([
                'date_log' => date('Y-m-d H:i:s'),
                'message' => 'Ceci est le message ' . $i . ' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam  ',
                'type_log' => $type_logs[rand(0, 2)],
                'user_id' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
