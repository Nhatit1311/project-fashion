<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        DB::table('configs')->delete();

        DB::table('configs')->truncate();

        DB::table('configs')->insert([
            [
                'list_image'    =>  'https://media-fmplus.cdn.vccloud.vn/uploads/tags/78803bfa-dcae-4083-bcfd-9cd655a44baa.png,https://media-fmplus.cdn.vccloud.vn/uploads/tags/1741fb96-e4fa-432e-824e-6724b267283d.png',
                'list_title'    =>  'Bst Black & White|Bst Denim',
                'list_des'      =>  'BLACK & WHITE // GAM MÀU HUYỀN THOẠI|DENIM COLLECTION 2023 // BẢN PHỐI THỜI THƯỢNG CHO NÀNG',
                'list_link'     =>  '/list-product/3|/list-product/5',
                'list_bestsale' => '1,2,3,19,20,21,43,44,45',
                'list_sale'     => '10,11,12,55,56,57',
                'image_slide_1' => 'https://media-fmplus.cdn.vccloud.vn/uploads/sliders/f9b57146-c760-4abc-97f8-d6f8c21be734.png',
                'image_slide_2' => 'https://media-fmplus.cdn.vccloud.vn/uploads/sliders/c1c06fe7-de28-42ca-a92c-1276f0b68dd4.png'
            ]
        ]);
    }
}
