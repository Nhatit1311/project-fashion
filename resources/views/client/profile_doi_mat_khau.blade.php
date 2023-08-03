@extends('client.profile')
@section('noi_dung_profile')
    <div id="app_rep">
        <div class="row">
            <div class="col-lg-7 col-md-12 col-12">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Mật Khẩu Cũ</label>
                        <input v-model="profile.old_password" type="password" placeholder="Nhập mật khẩu hiện tại"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật Khẩu Mới</label>
                        <input v-model="profile.new_password" type="password" placeholder="Nhập mật khẩu mới"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhập lại mật khẩu mới</label>
                        <input v-model="profile.re_password" type="password" placeholder="Nhập lại mật khẩu mới"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col text-end">
                        <button v-on:click="changePassword()" type="button" class="btn btn-primary">LƯU</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_profile')
    <script>
        $(document).ready(function() {
            new Vue({
                el: '#app_rep',
                data: {
                    profile: {},
                },
                methods: {
                    changePassword() {
                        axios
                            .post('{{ Route('updatePasswordCustomer') }}', this.profile)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0], "Error");
                                });
                            });
                    },
                },
            });
        });
    </script>
@endsection
