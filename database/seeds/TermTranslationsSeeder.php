<?php

use Crockett\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class TermTranslationsSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'term_translations';
        $this->filename = base_path() . '/database/seeds/csvs/terms_translations.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();
        DB::table($this->table)->delete();

        parent::run();
    }
}