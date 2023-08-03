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
                        <fieldset>
                            <label class="label">Nhập địa chỉ email</label>
                            <input v-model="obj.email" class="form-control" type="email">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <button v-on:click="fotgotPassword()" class="btn-primary d-block mt-4 btn-signin">Lấy mật
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
                    obj: {},
                },
                created() {

                },
                methods: {
                    fotgotPassword() {
                        axios
                            .post('{{ Route('actionForgotPassword') }}', this.obj)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0], 'Error');
                                });
                            });
                        i
                    },
                },
            });
        });
    </script>
@endsection
