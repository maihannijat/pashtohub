<?php

use Crockett\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class TermsSeeder extends CsvSeeder
{

    public function __construct()
    {

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

        $this->table = 'terms';
        $this->filename = base_path() . '/database/seeds/csvs/terms.csv';

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();
        DB::table($this->table)->delete();

        parent::run();
    }
}