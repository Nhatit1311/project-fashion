@extends('client.master')
@section('noi_dung')
    <main id="app" class="content-for-layout">
        <div class="login-page mt-100">
            <div class="container">
                <div class="section-header mb-3">
                    <h5 class="section-heading text-center">Quên Mật Khẩu</h5>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Mật Khẩu Mới</label>
                            <input v-model="obj.new_password" type="password" placeholder="Nhập mật khẩu mới"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input v-model="obj.re_password" type="password" placeholder="Nhập lại mật khẩu mới"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button v-on:click="updatePassword()" class="btn-primary d-block mt-4 btn-signin">Lấy mật
                            khẩu</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            new Vue({
                el: '#app',
                data: {
                    obj: {
                        'hash_reset': {!! json_encode($hash_reset) !!},
                        'new_password': '',
                        're_password': '',
                    },
                },
                created() {

                },
                methods: {
                    updatePassword() {
                        axios
                            .post('{{ Route('actionUpdatePassword') }}', this.obj)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    setTimeout(() => {
                                        window.location.replace(
                                            '{{ Route('listCart') }}');
                                    }, 500);
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0], 'Error');
                                });
                            });
                    },
                },
            });
        });
    </script>
@endsection
