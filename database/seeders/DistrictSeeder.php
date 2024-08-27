<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(base_path('database/seeders/csv/districts.csv'), 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        DB::table('districts')->truncate();
        $now = Carbon::now();

        foreach ($csv as $row) {
            DB::table('districts')->insert([
                'id' => $row['id'],
                'regency_id' => $row['regency_id'],
                'name' => $row['name'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
