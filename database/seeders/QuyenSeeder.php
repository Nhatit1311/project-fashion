<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quyens')->delete();

        DB::table('quyens')->truncate();

        DB::table('quyens')->insert([
            [
                'ten_quyen'         => 'Admin',
                'slug'              => Str::slug('Admin'),
                'list_rule'         => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37',
            ],
            [
                'ten_quyen'            => 'Nhân viên',
                'slug'              => Str::slug('Nhân viên'),
                'list_rule'        => '1,2,3,5,6,7,8,10,11,12,15,16,17,18,20,23,24,25,26,27,28,29,31,32,33,34,35',
            ],
        ]);
    }
}
