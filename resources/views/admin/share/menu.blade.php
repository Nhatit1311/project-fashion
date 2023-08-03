<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="/assets_admin/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rukada</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left' id="btnMenuDong"></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <div class="parent-icon">
                        <i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Tổng Hợp</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/cau-hinh">
                    <div class="parent-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="menu-title">Cấu Hình</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/tai-khoan/index-vue">
                    <div class="parent-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="menu-title">Tài Khoản Admin</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/khach-hang">
                    <div class="parent-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="menu-title">Tài Khoản Khách Hàng</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/chuyen-muc/index-vue">
                    <div class="parent-icon">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <div class="menu-title">Chuyên Mục</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/san-pham/index">
                    <div class="parent-icon">
                        <i class="fa-brands fa-product-hunt"></i>
                    </div>
                    <div class="menu-title">Sản Phẩm</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/nha-cung-cap/index">
                    <div class="parent-icon">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="menu-title">Nhập Nhà Cung Cấp/Nhập Kho</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/don-hang">
                    <div class="parent-icon">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                    </div>
                    <div class="menu-title">Chi Tiết Đơn Hàng</div>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                  <div class="parent-icon"><i class="fa-solid fa-chart-simple"></i>
                  </div>
                  <div class="menu-title">Thống Kê</div>
              </a>
              <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="{{ Route('viewSoLuongKhachHang') }}"><i class="bx bx-right-arrow-alt"></i>Thống Kê Số Lượng Khách Hàng</a>
                  </li>
                  <li> <a class="dropdown-item" href="{{ Route('viewSoLuongDonHang') }}"><i class="bx bx-right-arrow-alt"></i>Thống Kê Số Lượng Đơn Hàng</a>
                  </li>
                  <li> <a class="dropdown-item" href="{{ Route('viewTongTien') }}"><i class="bx bx-right-arrow-alt"></i>Thống Kê Tiền Hàng</a>
                  </li>
                  <li> <a class="dropdown-item" href="{{ Route('viewTongTienSanPham') }}"><i class="bx bx-right-arrow-alt"></i>Thống Kê Số Tiền Sản Phẩm</a>
                  </li>
                </ul>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/tin-tuc/index">
                    <div class="parent-icon">
                        <i class="fa-solid fa-square-rss"></i>
                    </div>
                    <div class="menu-title">Tin Tức</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/lien-he">
                    <div class="parent-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="menu-title">Thông Tin Phản Hồi</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/quyen">
                    <div class="parent-icon">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="menu-title">Phân Quyền</div>
                </a>
            </li>
        </ul>
    </nav>
</div>
