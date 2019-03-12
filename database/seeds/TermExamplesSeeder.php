<?php

use Illuminate\Database\Seeder;

class TermExamplesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Models\TermExample::class, 10)->create(); /// getting an error here. 
    }
}
