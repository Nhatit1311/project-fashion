<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TongHopController extends Controller
{
    public function index()
    {
        $data = KhachHang::select(DB::raw('COUNT(khach_hangs.id) as tong_khach_hang'))
        ->first();

        $data1 = DonHang::select(DB::raw('COUNT(id) as tong_don_hang'),
             DB::raw('SUM(tien_hang) as tong_tien'),
            )
       ->first();
        return view('admin.page.tong_hop.index',compact('data','data1'));
    }
}
