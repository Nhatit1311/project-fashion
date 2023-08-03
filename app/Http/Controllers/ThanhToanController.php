<?php

namespace App\Http\Controllers;

use App\Jobs\XacNhanDonHangJob;
use App\Models\ChiTietBanHang;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use App\Models\VnPay;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

date_default_timezone_set('Asia/Ho_Chi_Minh');


class ThanhToanController extends Controller
{
    public function indexvnpay($id)
    {
        $hoaDon = DonHang::find($id);
        // dd($hoaDon);
        return view('client.vnpay.index_vnpay', compact('hoaDon'));
    }

    public function actionThanhToan(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $data = $request->all();
        // dd($data);
        DB::beginTransaction();
        try {
            $vnp_TxnRef = $data['hash_don_hang']; //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = $data['amount']; // Số tiền thanh toán
            $vnp_Locale = $data['language']; //Ngôn ngữ chuyển hướng thanh toán
            $vnp_BankCode = $data['bankCode']; //Mã phương thức thanh toán
            $vnp_IpAddr = $request->ip(); //IP Khách hàng thanh toán
            $now = Carbon::now()->format("YmdHis");
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => env("VN_TMNCODE"),
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => $now,
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => env("VNP_RETURNURL"),
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes', strtotime(Carbon::parse($now)))),
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = env("VNP_URL") . "?" . $query;

            $vnpSecureHash =   hash_hmac('sha512', $hashdata, env("VNP_HASHSECRET")); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

            return redirect($vnp_Url);
            DB::commit();
            // return
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }

    public function responeVNPay(Request $request)
    {
        // dd($request->all());
        $url = session('url_prev', '/');
        if ($request->vnp_ResponseCode == "00") {
            VnPay::create([
                'vnp_Amount'            => $request->vnp_Amount,
                'vnp_BankCode'          => $request->vnp_BankCode,
                'vnp_BankTranNo'        => $request->vnp_BankTranNo,
                'vnp_OrderInfo'         => $request->vnp_OrderInfo,
                'vnp_ResponseCode'      => $request->vnp_ResponseCode,
                'vnp_TransactionStatus' => $request->vnp_TransactionStatus,
                'vnp_TxnRef'            => $request->vnp_TxnRef,
            ]);

            // $this->apSer->thanhtoanonline(session('cost_id'));
            $hoadon = DonHang::where('hash_don_hang', $request->vnp_TxnRef)->first();
            $hoadon->thanh_toan = 1;
            $hoadon->save();
            $khachHang                  = KhachHang::find($hoadon->id_khach_hang);
            $gioHang  = ChiTietBanHang::where('id_khach_hang', $khachHang->id)
                ->where('id_don_hang', $hoadon->id)
                ->join('san_phams', 'chi_tiet_ban_hangs.id_san_pham', 'san_phams.id')
                ->select('chi_tiet_ban_hangs.*', 'san_phams.ten_san_pham', 'san_phams.slug_san_pham', 'san_phams.hinh_anh', 'san_phams.gia_ban', 'san_phams.gia_khuyen_mai')
                ->get();
            // dd($gioHang->toArray());
            $info['nguoi_mua']          = $khachHang->ho_va_ten;
            $info['nguoi_nhan']         = $hoadon->ho_lot . ' ' . $hoadon->ten_khach;
            $info['dia_chi']            = $hoadon->dia_chi;
            $info['email']              = $khachHang->email;
            $info['tong_tien']          = $hoadon->tong_thanh_toan;
            $info['ma_don']             = $hoadon->hash_don_hang;

            XacNhanDonHangJob::dispatch($info, $gioHang);
            toastr()->success("Đã thanh toán phí dịch vụ thành công");
            return redirect("/");
        }else{
            $hoadon = DonHang::where('hash_don_hang', $request->vnp_TxnRef)->first();
            $hoadon->delete();
        }
        session()->forget('url_prev');
        toastr()->error('Dịch vụ thanh toán đã bị hủy');
        return redirect($url);
    }
}
