<?php

namespace Database\Seeders;

use App\Models\ChiTietBanHang;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DonHangSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Xóa và truncate các bảng liên quan trước khi bắt đầu seeding
        DB::table('chi_tiet_ban_hangs')->truncate();
        DB::table('don_hangs')->truncate();

        $tong_so_don = 0;
        $list_customer = KhachHang::all();
        $ngay_tru = 30;

        while ($tong_so_don < 60) {
            $temp = rand(1, 45);
            $ngay_tru = $ngay_tru - $temp < 0 ? 0 : $ngay_tru - $temp;

            $so_don = rand(1, 7);
            $tong_so_don += $tong_so_don + $so_don > 60 ? 60 - $tong_so_don : $so_don;

            for ($i = 0; $i < $so_don; $i++) {
                $khach_hang = $list_customer->random();
                $ho_lot = explode(' ', $khach_hang->ho_va_ten)[0];
                $ten_khach = str_replace($ho_lot . ' ', '', $khach_hang->ho_va_ten);

                // Tạo ngày ngẫu nhiên từ 1/7/2023 đến thời gian hiện tại
                $created_at = $faker->dateTimeBetween('2023-07-01', 'now');

                $don_hang = DonHang::create([
                    'ho_lot'          => $ho_lot,
                    'ten_khach'       => $ten_khach,
                    'ho_va_ten'       => $khach_hang->ho_va_ten,
                    'email'           => $khach_hang->email,
                    'so_dien_thoai'   => $khach_hang->so_dien_thoai,
                    'dia_chi'         => 'Hải Châu, Đà Nẵng',
                    'id_khach_hang'   => $khach_hang->id,
                    'hash_don_hang'   => Str::random(7),
                    'phi_ship'        => null,
                    'tien_hang'       => null,
                    'tong_thanh_toan' => null,
                    'thanh_toan'      => 1,
                    'giao_hang'       => rand(0, 2),
                    'created_at'      => $created_at,
                ]);

                $sanPham = SanPham::all();

                $total = 0;
                $count_ship = 0;

                for ($j = 0; $j < rand(1, 7); $j++) {
                    $randomProduct = $sanPham->random();
                    $so_luong = rand(1, 5);
                    $don_gia = $randomProduct->gia_khuyen_mai > 0 ? $randomProduct->gia_khuyen_mai : $randomProduct->gia_ban;
                    $thanh_tien_mua = $randomProduct->gia_khuyen_mai > 0 ? $so_luong * $randomProduct->gia_khuyen_mai : $so_luong * $randomProduct->gia_ban;

                    ChiTietBanHang::create([
                        'id_san_pham'     => $randomProduct->id,
                        'id_khach_hang'   => $khach_hang->id,
                        'so_luong'        => $so_luong,
                        'don_gia'         => $don_gia,
                        'thanh_tien'      => $thanh_tien_mua,
                        'id_don_hang'     => $don_hang->id,
                        'ten_san_pham'    => $randomProduct->ten_san_pham,
                        'created_at'      => $created_at,
                    ]);

                    $total += $don_gia * $so_luong;
                    $count_ship += $so_luong;
                }

                // Tính phí ship
                if ($count_ship < 3) {
                    $ship = 30000;
                } else {
                    $ship = $count_ship * 10000;
                }

                // Gán giá trị phí ship, tiền hàng và tổng thanh toán vào đơn hàng
                $don_hang->hash_don_hang     = 'DH' . (2342259 + $don_hang->id);
                $don_hang->phi_ship          = $ship;
                $don_hang->tien_hang         = $total;
                $don_hang->tong_thanh_toan   = $total + $ship;

                $don_hang->save();
            }
        }
    }
}
