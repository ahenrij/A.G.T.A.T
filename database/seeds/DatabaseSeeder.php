<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Model::unguard();
        $this->call(StructureTableSeeder::class);
        $this->call(TypeUserTableSeeder::class);
        $this->call(GroupeTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(TypeVehiculesTableSeeder::class);
        $this->call(TypeTitresTableSeeder::class);
        $this->call(ZonesTableSeeder::class);
        $this->call(LogTableSeeder::class);
        $this->call(VehiculesTableSeeder::class);
        $this->call(TitreTableSeeder::class);
//        Model::reguard();
    }
}
