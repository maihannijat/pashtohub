<?php

use Crockett\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class LookupsSeeder extends CsvSeeder
{

    public function __construct()
    {
        $this->table = 'lookups';
        $this->filename = base_path() . '/database/seeds/csvs/lookups.csv';
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