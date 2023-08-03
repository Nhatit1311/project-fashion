<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchThongKebanHangRequest;
use App\Models\ChiTietBanHang;
use App\Models\DonHang;
use App\Models\KhachHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public  function viewSLKH()
    {
        return view('admin.page.thong_ke.index_tkkh');
    }

    public function dataSLKH(Request $request)
    {
        $begin      = $request->begin;
        $end        = $request->end;

        $khach_hang_data = KhachHang::whereDate('created_at', '>=', $begin)
            ->whereDate('created_at', '<=', $end)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as ngay_tao_khach_hang'),
                DB::raw('COUNT(*) as so_luong_khach_hang')
            )
            ->groupBy('ngay_tao_khach_hang')
            ->get();

        $ngay_tao_khach_hang   = [];
        $so_luong_khach_hang   = [];

        foreach ($khach_hang_data as $key => $value) {
            array_push($ngay_tao_khach_hang, $value->ngay_tao_khach_hang);
            array_push($so_luong_khach_hang, $value->so_luong_khach_hang);
        }


        return response()->json([
            'status'                    => 1,
            'data'                      => $khach_hang_data,
            'ngay_tao_khach_hang'       => $ngay_tao_khach_hang,
            'so_luong_khach_hang'       => $so_luong_khach_hang,
        ]);
    }

    public function chiTietSLKH(Request $request)
    {
        $ngay   = Carbon::createFromFormat('d/m/Y', $request->ngay_tao_khach_hang)->format('Y-m-d');

        $data   = KhachHang::whereDate('created_at', $ngay)
            ->get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function viewSLDH()
    {
        return view('admin.page.thong_ke.index_tkdh');
    }

    public function dataSLDH(Request $request)
    {
        $begin      = $request->begin;
        $end        = $request->end;

        $data = DonHang::whereDate('created_at', '>=', $begin)
            ->whereDate('created_at', '<=', $end)
            ->where('thanh_toan', 1)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as ngay_don_hang'),
                DB::raw('COUNT(*) as so_luong_don_hang')
            )
            ->groupBy('ngay_don_hang')
            ->get();

        $ngay_don_hang   = [];
        $so_luong_don_hang   = [];

        foreach ($data as $key => $value) {
            array_push($ngay_don_hang, $value->ngay_don_hang);
            array_push($so_luong_don_hang, $value->so_luong_don_hang);
        }


        return response()->json([
            'status'                    => 1,
            'data'                      => $data,
            'ngay_don_hang'       => $ngay_don_hang,
            'so_luong_don_hang'       => $so_luong_don_hang,
        ]);
    }

    public function chiTietSLDH(Request $request)
    {
        $ngay   = Carbon::createFromFormat('d/m/Y', $request->ngay_don_hang)->format('Y-m-d');

        $data   = DonHang::whereDate('created_at', $ngay)
                        ->where('thanh_toan', 1)
                        ->get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function viewTH()
    {
        return view('admin.page.thong_ke.index_tong_tien');
    }

    public function dataTH(Request $request)
    {
        $begin      = $request->begin;
        $end        = $request->end;

        $data = DonHang::whereDate('created_at', '>=', $begin)
            ->whereDate('created_at', '<=', $end)
            ->where('thanh_toan', 1)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as ngay_don_hang'),
                DB::raw('SUM(tien_hang) as tong_tien_hang')
            )
            ->groupBy('ngay_don_hang')
            ->get();

        $ngay_don_hang   = [];
        $tong_tien_hang   = [];

        foreach ($data as $key => $value) {
            array_push($ngay_don_hang, $value->ngay_don_hang);
            array_push($tong_tien_hang, $value->tong_tien_hang);
        }


        return response()->json([
            'status'                    => 1,
            'data'                      => $data,
            'ngay_don_hang'       => $ngay_don_hang,
            'tong_tien_hang'       => $tong_tien_hang,
        ]);
    }

    public function chiTietTH(Request $request)
    {
        $ngay   = Carbon::createFromFormat('d/m/Y', $request->ngay_don_hang)->format('Y-m-d');

        $data   = DonHang::whereDate('created_at', $ngay)
                        ->where('thanh_toan', 1)
                        ->get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function viewTHSP()
    {
        return view('admin.page.thong_ke.index_tien_sp');
    }

    public function dataTHSP(Request $request)
    {
        $begin = $request->begin;
        $end = $request->end;

        $data = DonHang::join('chi_tiet_ban_hangs', 'chi_tiet_ban_hangs.id_don_hang', 'don_hangs.id')
            ->join('san_phams', 'san_phams.id', 'chi_tiet_ban_hangs.id_san_pham')
            ->whereDate('don_hangs.created_at', '>=', $begin)
            ->whereDate('don_hangs.created_at', '<=', $end)
            ->where('thanh_toan', 1)
            ->select('chi_tiet_ban_hangs.id_san_pham', 'don_hangs.created_at', DB::raw('SUM(chi_tiet_ban_hangs.thanh_tien) as tong_tien_ban'), DB::raw('COUNT(chi_tiet_ban_hangs.id_san_pham) as so_lan'), 'san_phams.ten_san_pham')
            ->groupBy('chi_tiet_ban_hangs.id_san_pham', 'don_hangs.created_at', 'san_phams.ten_san_pham')
            ->orderByDESC('tong_tien_ban')
            ->get();

        $ten_san_pham = [];
        $tong_tien_ban = [];

        foreach ($data as $item) {
            array_push($ten_san_pham, $item->ten_san_pham);
            array_push($tong_tien_ban, $item->tong_tien_ban);
        }

        return response()->json([
            'status'          => 1,
            'data'            => $data,
            'ten_san_pham'    => $ten_san_pham,
            'tong_tien_ban'   => $tong_tien_ban,
        ]);
    }

    public function chiTietTHSP(Request $request)
    {
        // dd($request->all());
        $data       = ChiTietBanHang::join('don_hangs', 'don_hangs.id', 'chi_tiet_ban_hangs.id_don_hang')
                                    ->join('san_phams', 'san_phams.id', 'chi_tiet_ban_hangs.id_san_pham')
                                    ->where('chi_tiet_ban_hangs.id_san_pham', $request->id_san_pham)
                                    ->where('don_hangs.created_at', $request->created_at)
                                    ->where('don_hangs.thanh_toan', 1)
                                    ->select('chi_tiet_ban_hangs.*', 'don_hangs.*', 'san_phams.ten_san_pham')
                                    ->get();

        // dd($data->toArray());

        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }
}
