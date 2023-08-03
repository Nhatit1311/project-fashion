<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\LoginCustomerRequest;
use App\Http\Requests\UpdatePasswordCustomerRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Jobs\ForgotPasswordMailJob;
use App\Jobs\RegisterMailJob;
use App\Mail\ForgotPassword;
use App\Mail\RegisterMail;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{
    public function index_profile_repassword()
    {
        return view('client.profile_doi_mat_khau');
    }

    public function updatePasswordCustomer(UpdatePasswordCustomerRequest $request)
    {
        $user_login     = Auth::guard('customer')->user();
        // dd($user_login);
        if(Auth::guard('customer')->attempt(['email' => $user_login->email, 'password' => $request->old_password])) {
            $customer               = KhachHang::find($user_login->id);
            $customer->password     = bcrypt($request->new_password);
            $customer->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Mật khẩu cũ không đúng!',
            ]);
        }
    }

    public function index_profile_don_hang()
    {
        return view('client.profile_don_hang');
    }

    public function index_profile_customer()
    {
        return view('client.profile_customer');
    }

    public function DataCustomerProfile()
    {
        $data = Auth::guard('customer')->user();
        return response()->json([
            'data'    => $data,
        ]);
    }

    public function UpdateCustomerProfile(Request $request)
    {
        // $khachhang = Auth::guard('customer')->user();
        $khachhang = KhachHang::where('id', $request->id)->first();
        $data = $request->all();
        if ($khachhang) {
            $khachhang->update($data);

            return response()->json([
                'status'    => true,
                'message'   => 'Đã cập nhật được thông tin!',
            ]);
        }else{

            return response()->json([
                'status'    => false,
                'message'   => 'Khách hàng không tồn tại!',
            ]);
        }
        dd($data);


    }

    public function index_profile()
    {
        return view('client.profile');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        toastr()->success('Đã đăng xuất thành công!');
        return redirect('/');
    }

    public function index()
    {
        return view('client.auth');
    }

    public function active($hash_active)
    {
        $user = KhachHang::where('hash_active', $hash_active)->first();
        if ($user) {
            if ($user->is_active) {
                Toastr()->warning('Ê, kích hoạt rồi mà chú!');
                return redirect('/');
            } else {
                $user->is_active = 1;
                $user->save();
                Toastr()->success('Bạn đã kích hoạt tài khoản thành công!');
                return redirect('/auth');
            }
        } else {
            Toastr()->error('Thông tin không chính xác!');
            return redirect('/');
        }
    }

    public function register(CreateCustomerRequest $request)
    {
        $data               = $request->all();
        $data['ho_va_ten']  = $request->ho_lot . " " . $request->ten_khach;
        $data['password']   = bcrypt($request->password);
        $data['hash_active'] = Str::uuid();
        KhachHang::create($data);

        RegisterMailJob::dispatch($data);

        // for($i = 0; $i < 10; $i++) {
        //     // Mail::to($request->email)->send(new RegisterMail($data));
        //     // RegisterMailJob::dispatch($data);
        // }

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã tạo tài khoản thành công, vui lòng kiểm tra email!',
        ]);
    }

    public function login(Request $request)
    {
        $data  = $request->all();
        $check = Auth::guard('customer')->attempt($data);
        if ($check) {
            $user = Auth::guard('customer')->user();
            if ($user->is_active == 1) {
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã đăng nhập thành công!',
                ]);
            } else {
                Auth::guard('customer')->logout();
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Bạn cần kích hoạt tài khoản!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Tài khoản hoặc mật khẩu không đúng!',
            ]);
        }
    }

    public function forgotPassword()
    {
        return view('customer.forgotPassword');
    }

    public function actionForgotPassword(Request $request)
    {
        $user = KhachHang::where('email', $request->email)->first();

        if ($user) {
            $user->hash_reset = Str::uuid();
            $user->save();

            $dataMail['email'] = $user->email;
            $dataMail['ho_va_ten'] = $user->ho_va_ten;
            $dataMail['hash_reset'] = $user->hash_reset;

            $dataMail['link']          =   env('APP_URL') . '/update-password/' . $dataMail['hash_reset'];

            toastr()->success('Vui lòng kiểm tra email!');

            ForgotPasswordMailJob::dispatch($dataMail);

            return response()->json([
                'status'    => true,
                'message'   => 'Vui lòng kiểm tra email để cập nhật mật khẩu!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản không tôn tại!',
            ]);
        }
    }

    public function viewUpdatePassword($hash_reset)
    {
        return view('client.updatePassword', compact('hash_reset'));
    }

    public function actionUpdatePassword(UpdatePasswordRequest $request)
    {
        $data = $request->all();
        $data['password']   = bcrypt($request->new_password);

        $user = KhachHang::where('hash_reset', $request->hash_reset)->first();

        if ($user) {
            $user->update($data);

            $user->hash_reset = NULL;
            $user->save();

            return response()->json([
                'status'    => true,
                'message'   => 'Đã cập nhật mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản không tồn tại!',
            ]);
        }
    }

    public function Customer()
    {
        return view('customer.Customer');
    }

    public function viewKhachHangAdmin()
    {
        return view('admin.page.khach_hang.index');
    }

    public function dataKhachHang()
    {
        $data = KhachHang::get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroyKhachHang(Request $request)
    {
        // $check = $this->checkRule_post(9);
        // if(!$check) {
        //     return response()->json([
        //         'status'  => false,
        //         'message' => 'Bạn không có quyền truy cập chức năng này!',
        //     ]);
        // }

        KhachHang::where('id', $request->id)->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa khách hàng thành công!',
        ]);
    }
}
