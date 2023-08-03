@extends('client.master')
@section('noi_dung')
<div>
    <div class="product-tab-section mt-100">
        <div class="container">
            <div class="tab-list product-tab-list">
                <nav class="nav product-tab-nav">
                    <a class="product-tab-link tab-link {{ Route::is('viewProfileCustomer') ? 'active' : '' }}" href="/profile/customer">Thông Tin Cá Nhân</a>
                    <a class="product-tab-link tab-link {{ Route::is('viewProfileDonHang') ? 'active' : '' }}" href="/profile/don-hang">Đơn Hàng</a>
                    <a class="product-tab-link tab-link {{ Route::is('viewProfileRePassword') ? 'active' : '' }}" href="/profile/re-password">Đổi Mật Khẩu</a>
                </nav>
            </div>
            <div class="tab-content product-tab-content">
                @yield('noi_dung_profile')
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    @yield('js_profile');
@endsection
