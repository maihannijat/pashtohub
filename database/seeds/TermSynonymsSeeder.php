<?php

use Illuminate\Database\Seeder;

class TermSynonymsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Models\TermSynonym::class, 10)->create(); /// getting an error here. 
    }
}
