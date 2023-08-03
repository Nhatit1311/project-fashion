@extends('admin.share.master_page')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Danh Sách Khách Hàng
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle text-nowrap">#</th>
                                    <th class="text-center align-middle text-nowrap">Họ Và Tên</th>
                                    <th class="text-center align-middle text-nowrap">Email</th>
                                    <th class="text-center align-middle text-nowrap">Số Điện Thoại</th>
                                    <th class="text-center align-middle text-nowrap">Giới Tính</th>
                                    <th class="text-center align-middle text-nowrap">Ngày Sinh</th>
                                    <th class="text-center align-middle text-nowrap">Kích Hoạt</th>
                                    <th class="text-center align-middle text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle text-nowrap">@{{ key + 1 }}</th>
                                        <td class="text-center align-middle text-nowrap">@{{ value.ho_va_ten }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.email }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.so_dien_thoai }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-if="value.gioi_tinh == 1" class="btn btn-primary" style="width : 100px">Nam</button>
                                            <button v-else-if="value.gioi_tinh == 0" class="btn btn-danger" style="width : 100px">Nữ</button>
                                            <button v-else class="btn btn-secondary" style="width : 100px">Khác</button>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.ngay_sinh }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-if="value.is_active == 1" class="btn btn-success" style="width : 150px">Đã Kích Hoạt</button>
                                            <button v-else class="btn btn-warning" style="width : 150px">Chưa Kích Hoạt</button>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="del = value" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Xóa Khách Hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <input class="form-control" type="hidden" id="delete_id" placeholder="Nhập vào id cần xóa">
                            <p>Bạn hãy chắc chắn là sẽ xóa khách hàng <b>@{{del.ho_va_ten}}</b> này. Việc này không thể hoàn tác!</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button v-on:click="destroy()" type="button" class="btn btn-danger">Xóa</button>
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
                el      :   '#app',
                data    :   {
                    list : [],
                    del  : {},
                },
                created()   {
                    this.loadData();
                },
                methods :   {
                    loadData() {
                        axios
                            .post('/admin/khach-hang/data')
                            .then((res) => {
                                this.list = res.data.data;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0], 'Error');
                                });
                            });
                    },

                    destroy() {
                        axios
                            .post('/admin/khach-hang/destroy', this.del)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0], 'Error');
                                });
                            });
                    }
                },
            });
        });
    </script>
@endsection
