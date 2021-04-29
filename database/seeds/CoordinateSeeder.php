<?php

use Illuminate\Database\Seeder;

class CoordinateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Coordinate::class, 20)->create();
    }
}
