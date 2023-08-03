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
                                    <th class="text-center align-middle text-nowrap">Tình Trạng</th>
                                    <th class="text-center align-middle text-nowrap">Action</th>
                                    <th class="text-center align-middle text-nowrap">Ghi Chú</th>
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
                                            <template v-if="value.tinh_trang == 1">
                                                <button v-on:click="doiTrangThai(value)" class="btn btn-success"
                                                    style="width : 150px">Đã Phản Hồi</button>
                                            </template>
                                            <template v-else>
                                                <button v-on:click="doiTrangThai(value)" class="btn btn-warning"
                                                    style="width : 150px">Chưa Phản
                                                    Hồi</button>
                                            </template>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="del = value" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">Xóa</button>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <i v-on:click="del = value" class="fa-solid fa-comment-dots fa-2x"
                                                data-bs-toggle="modal" data-bs-target="#phanhoiModal"></i>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Xóa Thông Tin Phản Hồi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input class="form-control" type="hidden" id="delete_id"
                                        placeholder="Nhập vào id cần xóa">
                                    <p>Bạn hãy chắc chắn là sẽ xóa phản hồi khách hàng <b>@{{ del.ho_va_ten }}</b> này.
                                        Việc này không thể hoàn tác!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button v-on:click="delete_phan_hoi()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="phanhoiModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Thông tin phản hồi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>@{{ del.ghi_chu }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
        new Vue({
            el: '#app',
            data: {
                list: [],
                del: {},
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .post('/admin/lien-he/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                delete_phan_hoi() {
                    axios
                        .post('/admin/lien-he/delete', this.del)
                        .then((res) => {
                            if (res.data.status) {
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
                },
                doiTrangThai(payload) {
                        axios
                            .post('{{ Route('statusLienHe') }}', payload)
                            .then((res) => {
                                this.loadData();
                                toastr.warning("Đã đổi trạng thái", "Thành Công!")
                            });
                    },
            },
        });
    </script>
@endsection
