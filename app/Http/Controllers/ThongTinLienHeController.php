<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhanHoiRequest;
use App\Models\ThongTinLienHe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThongTinLienHeController extends Controller
{
    public function index()
    {
        return view('admin.page.thong_tin_phan_hoi.index');
    }

    public function data(Request $request)
    {
        $data = ThongTinLienHe::get();
        return response()->json([
            'data'    => $data,
        ]);
    }

    public function store(PhanHoiRequest $request)
    {
        $data = $request->all();
        ThongTinLienHe::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã gửi phản hòi thành công!',
        ]);
    }
    public function destroy(Request $request)
    {
        // $check = $this->checkRule_post(9);
        // if(!$check) {
        //     return response()->json([
        //         'status'  => false,
        //         'message' => 'Bạn không có quyền truy cập chức năng này!',
        //     ]);
        // }
       $xoa = ThongTinLienHe::find($request->id);
       $xoa->delete();

        return response()->json([
            'status'    => true,
            'message' => 'Xóa phản hồi thành công!',
        ]);
    }


    public function status(Request $request)
    {

        $lien_he = ThongTinLienHe::where('id', $request->id)->first();
        if($lien_he) {
            $lien_he->tinh_trang = !$lien_he->tinh_trang;
            $lien_he->save();

            return response()->json([
                'status' => true,
                'message' => 'Đã Đổi Trạng Thái Thành Công',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Liên hệ không tồn tại hoặc không đủ quyền!',
            ]);
        }

    }
}
