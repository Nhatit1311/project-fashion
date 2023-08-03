<!doctype html>
<html lang="en" class="no-js">

<head>
    @include('client.css')
    <style>
        #top {
            width: 75px;
            height: 75px;
            position: fixed;
            bottom: 100px;
            right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #show_eyes {
            position: relative;
        }
        /* auth  */
        #eyes_show_re_password,
        #eye_show_password,
        #eyes_re_password,
        #eye_password {
            position: absolute;
            right: 1.5rem;
            bottom: 0.6rem;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="body-wrapper">
        @include('client.header')
        @include('client.menu')

        @yield('noi_dung')

        @include('client.footer')
        <button id="scrollup">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
        </button>
        @include('client.js')
        @yield('js')

        <!-- Modal -->
        <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <button v-if="trang_thai == 1" class="btn btn-primary"
                                v-on:click="trang_thai = 0">Đăng nhập</button>
                            <button v-else class="btn btn-primary" v-on:click="trang_thai = 1">Đăng ký</button>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="trang_thai == 1" class="login-page">
                            <b>@{{ thong_bao }}</b>
                            <form style="max-width: 100% !important;" v-on:submit.prevent="add()" id="formdata"
                                class="login-form common-form mx-auto">
                                <h2 class="section-heading text-center">ĐĂNG KÝ</h2>
                                <div class="row">
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Họ Lót</label>
                                            <input required name="ho_lot" type="text" />
                                        </fieldset>
                                    </div>
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Tên</label>
                                            <input required name="ten_khach" type="text" />
                                        </fieldset>
                                    </div>
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Email</label>
                                            <input required type="email" name="email" />
                                        </fieldset>
                                    </div>
                                    <div class="col-6" id="show_eyes">
                                        <fieldset>
                                            <label class="label">Mật Khẩu</label>
                                            <input required name="password" type="password" id="input_show_password"/>
                                            <i onclick="password()" class="fa-sharp fa-solid fa-eye-slash" id="eye_show_password"></i>
                                        </fieldset>
                                    </div>
                                    <div class="col-6" id="show_eyes">
                                        <fieldset>
                                            <label class="label">Nhập Lại Mật Khẩu</label>
                                            <input required name="re_password" type="password" id="input_re_show_password"/>
                                            <i onclick="re_password()" class="fa-sharp fa-solid fa-eye-slash" id="eyes_show_re_password"></i>
                                        </fieldset>
                                    </div>
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Số Điện Thoại</label>
                                            <input required name="so_dien_thoai" type="tel" />
                                        </fieldset>
                                    </div>
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Giới Tính</label>
                                            <select name="gioi_tinh">
                                                <option value="1">Nam</option>
                                                <option value="0">Nữ</option>
                                                <option value="2">Khác</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-6">
                                        <fieldset>
                                            <label class="label">Ngày Sinh</label>
                                            <input required name="ngay_sinh" type="date" />
                                        </fieldset>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit"
                                            class="btn-primary d-block mt-3 btn-signin">ĐĂNG KÝ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div v-else class="login-page">
                            <b>@{{ thong_bao }}</b>
                            <form v-on:submit.prevent="login()" id="formdata" class="login-form common-form mx-auto">
                                <div class="section-header mb-3 text-end">
                                    <h2 class="section-heading text-center">ĐĂNG NHẬP</h2>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <label class="label">Email</label>
                                            <input required type="email" name="email" />
                                        </fieldset>
                                    </div>
                                    <div class="col-12" id="show_eyes">
                                        <fieldset>
                                            <label class="label">Mật Khẩu</label>
                                            <input required name="password" type="password" id="input_show_password"/>
                                            <i onclick="password()" class="fa-sharp fa-solid fa-eye-slash" id="eye_show_password"></i>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="/forgot-password" class="text_14 d-block">Quên Mật Khẩu?</a>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button data-bs-dismiss="modal" type="submit"
                                            class="btn-primary d-block mt-3 btn-signin">ĐĂNG NHẬP</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div style="position: relative;">
        <a href="#" class="btn btn-warning rounded-circle" id="top">Top</a>
    </div> --}}

</body>
<script>
    new Vue({
        el: '#authModal',
        data: {
            thong_bao: '',
            trang_thai: 0,
        },
        created() {

        },
        methods: {
            add() {
                var paramObj = {};
                $.each($('#formdata').serializeArray(), function(_, kv) {
                    if (paramObj.hasOwnProperty(kv.name)) {
                        paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                        paramObj[kv.name].push(kv.value);
                    } else {
                        paramObj[kv.name] = kv.value;
                    }
                });

                axios
                    .post('/register', paramObj)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message);
                            this.thong_bao = res.data.message;
                            $('#authModal').modal('hide');
                        }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            login() {
                var paramObj = {};
                $.each($('#formdata').serializeArray(), function(_, kv) {
                    if (paramObj.hasOwnProperty(kv.name)) {
                        paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                        paramObj[kv.name].push(kv.value);
                    } else {
                        paramObj[kv.name] = kv.value;
                    }
                });

                axios
                    .post('/login', paramObj)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "Thành công!");
                            this.thong_bao = res.data.message;
                            location.reload();
                        } else {
                            toastr.error(res.data.message, "Error!");
                        }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            }
        },
    });
</script>
<script>
    $(document).ready(function() {
        $("#cong_sp").click(function() {
            var soLuongHienTai = parseInt($("#so_luong_sp").val());
            var soLuongMoi = soLuongHienTai + 1;
            $("#so_luong_sp").val(soLuongMoi);
        });

        // Hàm trừ số lượng
        $("#tru_sp").click(function() {
            var soLuongHienTai = parseInt($("#so_luong_sp").val());
            if (soLuongHienTai > 1) {
                var soLuongMoi = soLuongHienTai - 1;
                $("#so_luong_sp").val(soLuongMoi);
            }
        });
        $("#addtocart_me").click(function() {
            var paramObj = {
                'id_san_pham': $("#id_san_pham").val(),
                'so_luong': $("#so_luong_sp").val(),
            };
            axios
                .post('/add-to-cart', paramObj)
                .then((res) => {
                    if (res.data.status == 1) {
                        toastr.success(res.data.message, "Success!");
                    } else if (res.data.status == 2) {
                        toastr.warning(res.data.message, "Success!");
                    }
                })
                .catch((res) => {
                    $.each(res.response.data.errors, function(k, v) {
                        toastr.error(v[0]);
                    });
                });
        })
    });
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/64aba9da94cf5d49dc6292a9/1h4v8v0oq';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
<script>
    function password() {
        const eye_show_password = document.querySelector('#eye_show_password');

        eye_show_password.onclick = function() {
            eye_show_password.classList.toggle('fa-eye');
            eye_show_password.classList.toggle('fa-eye-slash');

            const input_show_password = document.querySelector('#input_show_password');
            if(input_show_password.type === 'password') {
                input_show_password.type = 'text';
            }else {
                input_show_password.type = 'password';
            }
        }
    }

    function re_password() {
        const eyes_show_re_password = document.querySelector('#eyes_show_re_password');

        eyes_show_re_password.onclick = function() {
            eyes_show_re_password.classList.toggle('fa-eye');
            eyes_show_re_password.classList.toggle('fa-eye-slash');

            const input_re_show_password = document.querySelector('#input_re_show_password');
            if(input_re_show_password.type === 'password') {
                input_re_show_password.type = 'text';
            }else {
                input_re_show_password.type = 'password';
            }
        }
    }
</script>
</html>
