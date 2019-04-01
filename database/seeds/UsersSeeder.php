<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'users';
        $this->filename = base_path().'/database/seeds/csvs/users.csv';
        $this->hashable = ['password', 'salt'];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();
        DB::table($this->table)->delete();

        parent::run();
    }
}
