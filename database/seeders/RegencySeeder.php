<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(base_path('database/seeders/csv/regencies.csv'), 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        DB::table('districts')->truncate();
        $now = Carbon::now();

        foreach ($csv as $row) {
            DB::table('regencies')->insert([
                'id' => $row['id'],
                'province_id' => $row['province_id'],
                'name' => $row['name'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
