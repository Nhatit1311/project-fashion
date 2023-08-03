@extends('admin.share.master_page')
@section('noi_dung')
    <div id="app" class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label>Ngày Bắt Đầu</label>
                            <input id="begin" v-model="begin" type="date" class="form-control mt-1">
                        </div>
                        <div class="col-3">
                            <label>Ngày Kết Thúc</label>
                            <input id="end" v-model="end" type="date" class="form-control mt-1">
                        </div>
                        <div class="col-3">
                            <button id="thong_ke" v-on:click="getData()" class="btn btn-primary"
                                style="margin-top: 33px">Thống Kê</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    THỐNG KÊ DỮ LIỆU
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ngày Tạo Tài Khoản</th>
                                <th>Số Lượng Khách Hàng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v, k) in list">
                                <td class="text-center">@{{ v.ngay_tao_khach_hang }}</td>
                                <td>@{{ v.so_luong_khach_hang }}</td>
                                <td class="text-center">
                                    <button v-on:click="xemChiTiet(v)" data-bs-toggle="modal" data-bs-target="#chiTietModal"
                                        class="btn btn-sm btn-primary">Chi Tiết</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Chi Tiết</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Họ và Tên</th>
                                            <th>Email</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Ngày Sinh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(v, k) in detail">
                                            <td>@{{ k + 1 }}</td>
                                            <td>@{{ v.ho_va_ten }}</td>
                                            <td>@{{ v.email }}</td>
                                            <td>@{{ v.so_dien_thoai }}</td>
                                            <td>@{{ formatDate(v.ngay_sinh) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                begin: '',
                end: '',
                list: [],
                detail: [],
            },
            created() {
                this.begin = '2023-07-01';
                this.end = moment().format('YYYY-MM-DD').toString();
            },
            methods: {
                getData() {
                    var payload = {
                        'begin': this.begin,
                        'end': this.end
                    };
                    axios
                        .post('{{ Route('dataSoLuongKhachHang') }}', payload)
                        .then((res) => {
                            this.list = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                formatDate(date) {
                        return moment(date).format("DD/MM/YYYY");
                },
                xemChiTiet(payload) {
                    axios
                        .post('{{ Route('chiTIetSoLuongKhachHang') }}', payload)
                        .then((res) => {
                            this.detail = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },

            },
        });

        var ten_du_lieu = [];
        var du_lieu = [];
        const ctx = document.getElementById('myChart');
        var char_13 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ten_du_lieu,
                datasets: [{
                    label: '# of Votes',
                    data: du_lieu,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                onClick: function(e) {
                    var activePoints = char_13.getElementsAtEventForMode(e, 'nearest', {
                        intersect: true
                    }, true);
                    if (activePoints.length > 0) {
                        var firstPoint = activePoints[0];
                        var label = char_13.data.labels[firstPoint.index];
                        var value = char_13.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];

                        // Xóa dữ liệu và màu sắc của ten_du_lieu đã chọn
                        var index = ten_du_lieu.indexOf(label);
                        if (index > -1) {
                            ten_du_lieu.splice(index, 1);
                            char_13.data.datasets[0].backgroundColor.splice(index, 1);
                        }

                        // Cập nhật biểu đồ
                        char_13.update();
                    }
                }
            }
        });

        function getChart() {
            var payload = {
                'begin': $("#begin").val(),
                'end': $("#end").val(),
            };
            axios
                .post('{{ Route('dataSoLuongKhachHang') }}', payload)
                .then((res) => {
                    ten_du_lieu = res.data.ngay_tao_khach_hang;
                    du_lieu = res.data.so_luong_khach_hang;
                    char_13.data.labels = ten_du_lieu;
                    char_13.data.datasets[0].data = du_lieu;
                    char_13.update();
                })
                .catch((res) => {
                    $.each(res.response.data.errors, function(k, v) {
                        toastr.error(v[0], 'Error');
                    });
                });
        }

        $("#thong_ke").click(function() {
            getChart();
        });
    </script>
@endsection
