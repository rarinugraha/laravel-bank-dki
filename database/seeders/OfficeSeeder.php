<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('offices')->insert([
            [
                'name' => 'Kantor Pusat',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'KCP Jakarta',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'KCP Depok',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
