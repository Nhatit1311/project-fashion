<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                'email'             =>  'nguyenvuhuy2110@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ho_va_ten'         =>  'Nguyễn Vũ Huy',
                'ngay_sinh'         =>  '2002-10-21',
                'so_dien_thoai'     =>  '0394682134',
                'id_quyen'          =>   1,
                'is_master'          =>  1,
            ],
            [
                'email'             =>  'truongquangvinh1999@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ho_va_ten'         =>  'Trương Quang Vinh',
                'ngay_sinh'         =>  '1997-04-01',
                'so_dien_thoai'     =>  '0906666666',
                'id_quyen'          =>   1,
                'is_master'          =>  1,
            ],
            [
                'email'             =>  'duynhat@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ho_va_ten'         =>  'Nguyễn Hoàng Duy Nhất',
                'ngay_sinh'         =>  '1997-04-01',
                'so_dien_thoai'     =>  '0906666666',
                'id_quyen'          =>   1,
                'is_master'          =>  1,
            ],
            [
                'email'             =>  'lengocphuc266@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ho_va_ten'         =>  'Lê Ngọc Phúc',
                'ngay_sinh'         =>  '1997-04-01',
                'so_dien_thoai'     =>  '0906666666',
                'id_quyen'          =>   1,
                'is_master'          =>  1,
            ],
            [
                'email'             =>  'dangconghuy99@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ho_va_ten'         =>  'Đặng Công Huy',
                'ngay_sinh'         =>  '1997-04-01',
                'so_dien_thoai'     =>  '0906666666',
                'id_quyen'          =>   2,
                'is_master'          =>  0,
            ],
        ]);
    }
}
