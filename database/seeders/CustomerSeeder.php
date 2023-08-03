<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khach_hangs')->delete();

        DB::table('khach_hangs')->truncate();

        DB::table('khach_hangs')->insert([
            [
                'ho_va_ten'         =>      'Nhất',
                'email'             =>      'duynhat@gmail.com',
                'password'          =>      bcrypt('123456'),
                'so_dien_thoai'     =>      '0987654321',
                'gioi_tinh'         =>      1,
                'ngay_sinh'         =>      '2002-10-21',
                'is_active'         =>      1,
                'ho_lot'            =>      'Nguyễn',
                'ten_khach'         =>      'Nhất',
                'created_at'        =>      '2023-07-01',
            ],
            [
                'ho_va_ten'         =>      'Nguyễn Vũ Huy',
                'email'             =>      'nguyenvuhuy2110@gmail.com',
                'password'          =>      bcrypt('123456'),
                'so_dien_thoai'     =>      '0394682134',
                'gioi_tinh'         =>      1,
                'ngay_sinh'         =>      '2002-10-21',
                'is_active'         =>      1,
                'ho_lot'            =>      'Nguyễn Vũ',
                'ten_khach'         =>      'Huy',
                'created_at'        =>      '2023-07-02',
            ],
            [
                'ho_va_ten'         =>      'Trương Quang Vinh',
                'email'             =>      'truongquangvinh1999@gmail.com',
                'password'          =>      bcrypt('123456'),
                'so_dien_thoai'     =>      '0394682134',
                'gioi_tinh'         =>      1,
                'ngay_sinh'         =>      '2002-10-21',
                'is_active'         =>      1,
                'ho_lot'            =>      'Trương Quang',
                'ten_khach'         =>      'Vinh',
                'created_at'        =>      '2023-07-03',
            ],
            [
                'ho_va_ten'         =>      'Lê Ngọc Phúc',
                'email'             =>      'lengocphuc266@gmail.com',
                'password'          =>      bcrypt('123456'),
                'so_dien_thoai'     =>      '0394682134',
                'gioi_tinh'         =>      1,
                'ngay_sinh'         =>      '2002-10-21',
                'is_active'         =>      1,
                'ho_lot'            =>      'Lê Ngọc',
                'ten_khach'         =>      'Phúc',
                'created_at'        =>      '2023-07-04',

            ],
            [
                'ho_va_ten'         =>      'Đặng Công Huy',
                'email'             =>      'dangconghuy99@gmail.com',
                'password'          =>      bcrypt('123456'),
                'so_dien_thoai'     =>      '0394682134',
                'gioi_tinh'         =>      1,
                'ngay_sinh'         =>      '2002-10-21',
                'is_active'         =>      1,
                'ho_lot'            =>      'Đặng Công',
                'ten_khach'         =>      'Huy',
                'created_at'        =>      '2023-07-05',

            ],
        ]);
    }
}
