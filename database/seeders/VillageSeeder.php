<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(base_path('database/seeders/csv/villages.csv'), 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        DB::table('villages')->truncate();
        $now = Carbon::now();

        foreach ($csv as $row) {
            DB::table('villages')->insert([
                'id' => $row['id'],
                'district_id' => $row['district_id'],
                'name' => $row['name'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
