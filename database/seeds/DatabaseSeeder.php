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
        //factory(App\Laps::class, 10)->create();
        //factory(App\PromoCodes::class, 20)->create();
        factory(App\User::class)->create();
    }
}
