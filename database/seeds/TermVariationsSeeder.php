<?php

use Illuminate\Database\Seeder;

class TermVariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\TermVariation::class, 10)->create(); /// getting an error here. 
    }
}
