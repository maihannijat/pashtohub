<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TermsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run() {

        $faker = Faker::create(); 

        factory(App\Models\Term::class, 10)->create()->each(function ($term) use ($faker) {
            DB::table('term_definitions')->insert([
                'term_id' => $term->id,
                'definition' => $faker->sentence,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]); 
            
            DB::table('term_examples')->insert([
                'term_id' => $term->id,
                'lang_id' => $faker->randomDigit,
                'example'=> $faker->sentence,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]); 

            DB::table('term_synonyms')->insert([
                'term_id' => $term->id,
                'synonym'=> $faker->word,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);  
            
            DB::table('term_translations')->insert([
                'term_id' => $term->id,
                'translation'=> $faker->sentence,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);  
            
            DB::table('term_variations')->insert([
                'term_id' => $term->id,
                'variant'=> $faker->word,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);              

        });
    }
}