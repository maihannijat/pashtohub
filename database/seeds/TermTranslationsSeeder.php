<?php

use Illuminate\Database\Seeder;

class TermTranslationsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Models\TermTranslation::class, 10)->create(); /// getting an error here. 
    }
}
