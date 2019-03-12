<?php

use Illuminate\Database\Seeder;

class TermDefinitionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Models\TermDefinition::class, 10)->create(); /// getting an error here. 
    }
}
