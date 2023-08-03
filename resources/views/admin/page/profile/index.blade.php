@extends('admin.share.master_page')
@section('noi_dung')
<div id="app">
<div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://static.vecteezy.com/system/resources/previews/002/002/403/original/man-with-beard-avatar-character-isolated-icon-free-vector.jpg" alt="Admin" class="rounded-circle p-1 bg-primary" width="310">
                            <div v-if="list.id_quyen == 1" class="mt-3">
                                <h4>@{{list.ho_va_ten}}</h4>
                                <p class="text-secondary mb-1">@{{ listquyen.ten_quyen }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        <b>Thông Tin Cá Nhân</b>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Họ Và Tên</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input v-model = "list.ho_va_ten" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Ngày Sinh</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input v-model = "list.ngay_sinh" type="date" class="form-control"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input disabled v-model = "list.email" type="email" class="form-control"  />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Số Điện Thoại</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input v-model = "list.so_dien_thoai" type="tel" class="form-control"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button v-on:click =  "accpectUpdate()"  type="button" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-header text-center">
                            <b>Đổi Lại Mật Khẩu</b>
                        </div>
                        <div class="card-body">
                            <div class=" col-md-12 col-12">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Mật Khẩu Cũ</label>
                                        <input v-model="profile.old_password"  type="password" placeholder="Nhập mật khẩu hiện tại"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mật Khẩu Mới</label>
                                        <input v-model="profile.new_password"  type="password" placeholder="Nhập mật khẩu mới"
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
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        new Vue({
            el      :       '#app',
            data    :       {
                list : {},
                listquyen : {},
                profile: {},
            },
            created()   {
                this.loadData();
            },
            methods :   {
                changePassword() {
                        axios
                            .post('/admin/profile/re-password', this.profile)
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
                accpectUpdate() {
                    axios
                        .post('/admin/profile/update', this.list)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                $('#updateModal').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                            $("#add").removeAttr("disabled");
                        });
                },
                loadData() {
                    axios
                        .post('/admin/profile/data')
                        .then((res) => {
                            this.list  =  res.data.data;
                            this.listquyen  =  res.data.dataquyen;
                        });
                }
            },
        });
    });
</script>
@endsection
