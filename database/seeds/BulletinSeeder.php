<?php

use Illuminate\Database\Seeder;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Bulletin::class, 20)->create();
    }
}
