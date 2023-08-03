<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThanhToanRequest;
use App\Jobs\XacNhanDonHangJob;
use App\Jobs\XacNhanJob;
use App\Models\ChiTietBanHang;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PHPViet\NumberToWords\Transformer;


class DonHangController extends Controller
{
    // public function auto()
    // {


    //     $client = new Client([
    //         'headers' => [ 'Content-Type' => 'application/json' ]
    //     ]);
    //     $now  = Carbon::today()->format('d/m/Y');
    //     $link = 'http://api.danangseafood.vn/api';
    //     $respone = $client->post($link,[
    //                 'body' => json_encode(
    //                     [
    //                         'begin'           => $now,
    //                         'end'             => $now,
    //                         'username'        => '0889470271',
    //                         'password'        => 'Vodinhquochuy@gmail1',
    //                         'accountNumber'   => '0651000883491'
    //                     ]
    //             )]);

    //     $res  = json_decode($respone->getBody()->getContents(), true);
    //     if($res['success']) {
    //         foreach($res['results'] as $key => $value) {
    //             $so_tien = str_replace(".", "", $value['Amount']);
    //             $so_tien = str_replace(",", "", $so_tien);
    //             if($value['CD'] == '+') {
    //                 $check = Transaction::where('Reference', $value['Reference'])->first();
    //                 if(!$check) {
    //                     $str            =  $value['Description'];
    //                     $id_don_hang    =  0;
    //                     $tim   = strpos($str, "DHBH");
    //                     if($tim) {
    //                         $str = substr($str, $tim, 11);

    //                         $donHang = DonHang::where('hash_don_hang', $str)->first();
    //                         if($donHang && $donHang->tong_thanh_toan <= $so_tien) {
    //                             $donHang->thanh_toan = 0;
    //                             $donHang->save();
    //                             $id_don_hang = $donHang->id;
    //                             //Gửi mail thông báo khách hàng
    //                             $khachHang              = KhachHang::find($donHang->id_khach_hang);
    //                             $info['email']          = $khachHang->email;
    //                             $info['ho_va_ten']      = $khachHang->ho_va_ten;
    //                             $info['so_tien']        = $donHang->tong_thanh_toan;
    //                             $info['don_hang']       = $str;

    //                             XacNhanJob::dispatch($info);
    //                         }
    //                     }

    //                     Transaction::create([
    //                         'tranDate'      =>  $value['tranDate'],
    //                         'Reference'     =>  $value['Reference'],
    //                         'Amount'        =>  $so_tien,
    //                         'Description'   =>  $value['Description'],
    //                         'id_don_hang'   =>  $id_don_hang,
    //                     ]);
    //                 }
    //             }
    //         }
    //     }
    // }

    public function checkout()
    {
        $khachHang = Auth::guard('customer')->user();

        $gioHang   = ChiTietBanHang::where('id_khach_hang', $khachHang->id)
            ->where('id_don_hang', 0)
            ->first();
        if ($gioHang) {
            return view('client.checkout', compact('khachHang'));
        } else {
            toastr()->error('Giỏ hàng không có sản phẩm để thanh toán');
            return redirect('/');
        }
    }

    public function process(ThanhToanRequest $request)
    {
        // dd($request->all());
        $khachHang = Auth::guard('customer')->user();

        $donHang   = DonHang::create([
            'ho_lot'            => $request->ho_lot,
            'ten_khach'         => $request->ten_khach,
            'ho_va_ten'         => $request->ho_lot . ' ' . $request->ten_khach,
            'email'             => $request->email,
            'so_dien_thoai'     => $request->so_dien_thoai,
            'dia_chi'           => $request->dia_chi,
            'id_khach_hang'     => $khachHang->id,
            'hash_don_hang'     => '',
        ]);
        $gioHang  = ChiTietBanHang::where('id_khach_hang', $khachHang->id)
            ->where('id_don_hang', 0)
            ->join('san_phams', 'chi_tiet_ban_hangs.id_san_pham', 'san_phams.id')
            ->select('chi_tiet_ban_hangs.*', 'san_phams.ten_san_pham', 'san_phams.slug_san_pham', 'san_phams.hinh_anh', 'san_phams.gia_ban', 'san_phams.gia_khuyen_mai')
            ->get();

        $total = 0;
        $count_ship = 0;
        foreach ($gioHang as $key => $value) {
            $don_gia = $value->gia_ban;
            if ($value->gia_khuyen_mai > 0) {
                $don_gia = $value->gia_khuyen_mai;
            }
            $total += $don_gia * $value->so_luong;
            $count_ship += $value->so_luong;
        }
        if ($count_ship < 3) {
            $ship = 30000;
        } else {
            $ship = $count_ship * 10000;
        }

        $donHang->hash_don_hang     = 'DH' . (2342459 + $donHang->id);
        $donHang->phi_ship          = $ship;
        $donHang->tien_hang         = $total;
        $donHang->tong_thanh_toan   = $total + $ship;
        $donHang->save();

        // $info['nguoi_mua']          = $khachHang->ho_va_ten;
        // $info['nguoi_nhan']         = $request->ho_lot . ' ' . $request->ten_khach;
        // $info['dia_chi']            = $request->dia_chi;
        // $info['email']              = $khachHang->email;
        // $info['tong_tien']          = $donHang->tong_thanh_toan;
        // $info['ma_don']             = $donHang->hash_don_hang;

        // XacNhanDonHangJob::dispatch($info, $gioHang);

        ChiTietBanHang::where('id_khach_hang', $khachHang->id)
            ->where('id_don_hang', 0)
            ->update([
                'id_don_hang'    =>  $donHang->id
            ]);
        return response()->json([
            'status'    => 1,
            'data'  => $donHang->id,
            'message'   => 'Đã đặt hàng thành công!',
        ]);
    }
    public function getDataDonHang()
    {
        $khachHang = Auth::guard('customer')->user();

        $data = DonHang::where('id_khach_hang', $khachHang->id)
            ->orderByDESC('created_at')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function chiTietDonHang($id)
    {
        $data = ChiTietBanHang::where('id_don_hang', $id)
            ->join('san_phams', 'chi_tiet_ban_hangs.id_san_pham', 'san_phams.id')
            ->select('chi_tiet_ban_hangs.*', 'san_phams.ten_san_pham', 'san_phams.slug_san_pham', 'san_phams.hinh_anh', 'san_phams.gia_ban', 'san_phams.gia_khuyen_mai')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function viewDH()
    {
        $check = $this->checkRule_get(31);
        if (!$check) {
            toastr()->error('Bạn không có quyền truy cập chức năng này!');
            return redirect('/admin');
        }

        return view('admin.page.danh_sach_don_hang.index');
    }
    public function getDataDonHangAdmin()
    {
        $check = $this->checkRule_get(31);
        if (!$check) {
            toastr()->error('Bạn không có quyền truy cập chức năng này!');
            return redirect('/admin');
        }

        $data = DonHang::get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function chiTietDonHangAdmin($id)
    {
        $check = $this->checkRule_get(32);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }

        $data = ChiTietBanHang::where('id_don_hang', $id)
            ->join('san_phams', 'chi_tiet_ban_hangs.id_san_pham', 'san_phams.id')
            ->select('chi_tiet_ban_hangs.*', 'san_phams.ten_san_pham', 'san_phams.slug_san_pham', 'san_phams.hinh_anh', 'san_phams.gia_ban', 'san_phams.gia_khuyen_mai')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function changeGiaoHang(Request $request)
    {
        $check = $this->checkRule_post(34);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }

        $donHang = DonHang::find($request->id);
        if ($donHang) {
            $donHang->giao_hang = $request->giao_hang;
            $donHang->save();

            return response()->json([
                'status' => true,
                'message' => 'Đổi trạng thái thành công',
            ]);
        }
    }
    public function inBill($id)
    {
        $chiTiet = ChiTietBanHang::join('san_phams', 'chi_tiet_ban_hangs.id_san_pham', 'san_phams.id')
            ->join('don_hangs', 'chi_tiet_ban_hangs.id_don_hang', 'don_hangs.id')
            ->where('id_don_hang', $id)
            ->select('chi_tiet_ban_hangs.*', 'don_hangs.*', 'san_phams.*')
            ->get();
        $phi_ship = 0;
        $tien_hang = 0;
        foreach ($chiTiet as $key => $value) {
            $phi_ship += $value->phi_ship;
            $tien_hang += $value->tien_hang;
        }
        $hoaDon = DonHang::find($id);

        $thanh_tien = $hoaDon->phi_ship + $hoaDon->tien_hang;

        // Hàm chuyển số thành chữ
        function chuyenSoThanhChu($so)
        {
            $mang_so = array(
                0 => 'Không',
                1 => 'Một',
                2 => 'Hai',
                3 => 'Ba',
                4 => 'Bốn',
                5 => 'Năm',
                6 => 'Sáu',
                7 => 'Bảy',
                8 => 'Tám',
                9 => 'Chín'
            );

            $mang_don_vi = array(
                '',
                'Nghìn',
                'Triệu',
                'Tỷ',
                'Nghìn tỷ',
                'Triệu tỷ',
                'Tỷ tỷ'
            );

            $so_chuoi = explode(',', $so);
            $chuoi = '';

            $so_tien = (int)str_replace(',', '', $so);

            if ($so_tien == 0) {
                return $mang_so[0] . ' đồng';
            }

            $i = 0;
            while ($so_tien > 0) {
                $phan_du = $so_tien % 1000;
                $so_tien = (int)($so_tien / 1000);

                if ($i > 0 && $phan_du > 0) {
                    $chuoi = ' ' . $mang_don_vi[$i] . ' ' . $chuoi;
                }

                $str_con = '';
                $tram = (int)($phan_du / 100);
                $chuc = (int)(($phan_du % 100) / 10);
                $don_vi = $phan_du % 10;

                if ($tram > 0) {
                    $str_con .= $mang_so[$tram] . ' trăm';
                }

                if ($chuc > 0) {
                    if ($chuc == 1) {
                        $str_con .= ' mười';
                    } else {
                        $str_con .= ' ' . $mang_so[$chuc] . ' mươi';
                    }
                }

                if ($don_vi > 0) {
                    if ($chuc == 0 && $tram > 0) {
                        $str_con .= ' lẻ ' . $mang_so[$don_vi];
                    } else {
                        $str_con .= ' ' . $mang_so[$don_vi];
                    }
                }

                $chuoi = $str_con . $chuoi;
                $i++;
            }

            return ucfirst($chuoi) . ' đồng';
        }
        $tt_chu = chuyenSoThanhChu($thanh_tien); // Chuyển "$thanh_tien" thành chữ
        // dd($thanh_tien . ' tương ứng là: ' . $tt_chu);

        $ngay = $hoaDon->created_at ? Carbon::parse($hoaDon->created_at)->format('d/m/Y') : 'Hóa đơn tạm tính';

        return view('admin.page.danh_sach_don_hang.inbill', compact('chiTiet', 'phi_ship', 'thanh_tien', 'tien_hang', 'ngay', 'tt_chu'));
    }
}
