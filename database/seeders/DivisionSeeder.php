<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    public function run()
    {
        $divisions = [
            [
                'name' => 'Multimedia',
                'description' => 'Divisi multimedia dan desain grafis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Support',
                'description' => 'Divisi dukungan teknis dan pemeliharaan sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Software Host',
                'description' => 'Divisi pengembangan dan hosting aplikasi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Network',
                'description' => 'Divisi jaringan dan infrastruktur',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Security',
                'description' => 'Divisi keamanan informasi dan sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hardware',
                'description' => 'Divisi perangkat keras dan maintenance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('divisions')->insert($divisions);
    }
}