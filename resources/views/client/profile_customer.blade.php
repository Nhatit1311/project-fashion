@extends('client.profile')
@section('noi_dung_profile')
<div id="app">
    <div class="row">
        <div class="col-lg-7 col-md-12 col-12">
            <div class="desc-content">
                <div class="col">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Họ Và Tên</label>
                            <input v-model = "list.ho_va_ten"   type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày Sinh</label>
                            <input v-model = "list.ngay_sinh" type="date"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input v-model = "list.so_dien_thoai" type="tel" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input disabled v-model = "list.email" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button v-on:click =  "accpectUpdate()"   class="position-relative review-submit-btn contact-submit-btn">LƯU</button>
                        </div>
                    </div>
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
            el      :       '#app',
            data    :       {
                list : {},
            },
            created()   {
                this.loadData();
            },
            methods :   {


                accpectUpdate() {
                    axios
                        .post('/profile/customer/update', this.list)
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
                        .post('/profile/customer/data')
                        .then((res) => {
                            this.list  =  res.data.data;
                        });
                }
            },
        });
    });
</script>
@endsection
