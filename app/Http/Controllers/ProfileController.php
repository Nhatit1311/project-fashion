<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdataPasswordAdminRequest;
use App\Http\Requests\UpdatePasswordAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.page.profile.index');
    }

    public function data()
    {
        $data = Auth::guard('admin')
                    ->user();
        $dataquyen = Admin::join('quyens', 'admins.id_quyen', 'quyens.id')
                    ->select('quyens.ten_quyen')
                    ->first();
        return response()->json([
            'data'    => $data,
            'dataquyen'    => $dataquyen,
        ]);
    }

    public function update(Request $request)
    {
        $admin = Admin::where('id',$request->id)->first();
        $data = $request->all();
        if($admin){
            $admin->update($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật thông tin!',
        ]);
        }else{
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản không tồn tại!',
            ]);
        }
    }
    public function repassword(UpdatePasswordAdminRequest $request)
    {
        $admin_login = Auth::guard('admin')->user();
        // dd($admin_login);
        if(Auth::guard('admin')->attempt(['email' => $admin_login->email, 'password' => $request->old_password])){
            $admin              = Admin::find($admin_login->id);
            // dd($admin);
            $admin->password    = bcrypt($request->new_password);
            $admin->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật mật khẩu thành công!',
            ]);
        }else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Mật khẩu cũ không đúng!',
            ]);
        }
    }

}
