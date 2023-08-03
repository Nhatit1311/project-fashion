<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 100mm;
            background: #FFF;
        }

        h1 {
            font-size: 1.5em;
            color: #222;
        }

        h2 {
            font-size: .9em;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #top,
        #mid,
        #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #top {
            min-height: 100px;
        }

        #mid {
            min-height: 80px;
        }

        #bot {
            min-height: 50px;
        }

        #top .logo {
            //float: left;
            height: 60px;
            width: 80px;
            background: url(/assets_client/img/logo.png) no-repeat;
            background-size: 80px 35px;
        }

        .clientlogo {
            float: left;
            height: 50px;
            width: 70px;
            background: url(/assets_client/img/logo.png) no-repeat;
            background-size: 80px 50px;
            border-radius: 50px;
        }

        .info {
            display: block;
            //float:left;
            margin-left: 0;
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            //padding: 5px 0 5px 15px;
            //border: 1px solid #EEE;
        }

        .tabletitle {
            font-size: .5em;
            background: #EEE;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .item {
            width: 24mm;
        }

        .itemtext {
            font-size: .5em;
            height: 2px;
        }

        #legalcopy {
            margin-top: 5mm;
        }

        }
    </style>
</head>

<body>

    <div id="invoice-POS">

        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>SHOP THỜI TRANG</h2>
            </div>
            <!--End Info-->
        </center>
        <!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <h2>Ngày: {{ $ngay }}</h3>
                    <p>
                        Address : Hải Châu, Đà Nẵng</br>
                        Email : matrix.cinema.211002@gmail.com</br>
                        Phone : 03.456.78.999</br>
                    </p>
            </div>
        </div>
        <!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Tên</h2>
                        </td>
                        <td class="item">
                            <h2>SL</h2>
                        </td>
                        <td class="item">
                            <h2>ĐG</h2>
                        </td>
                        <td class="item">
                            <h2>Ship</h2>
                        </td>
                        <td class="Rate">
                            <h2>TT</h2>
                        </td>
                    </tr>
                    @foreach ($chiTiet as $key => $value)
                        <tr class="service">
                            <td class="tableitem text-nowrap">
                                <p class="itemtext">{{ $value->ten_san_pham }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext text-nowrap">{{ $value->so_luong }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext text-nowrap">{{ number_format($value->don_gia, 0) }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext text-nowrap">{{ number_format($value->phi_ship, 0) }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext text-nowrap">{{ number_format($value->thanh_tien, 0) }}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!--End Table-->
            <div id="legalcopy">
                <div>
                    <table>
                            <tr class="service">
                                <td class="tableitem">
                                    <p class="itemtext text-nowrap">Tổng tiền</p>
                                </td>
                                <td class="tableitem text-end">
                                    <p class="itemtext text-nowrap">{{ number_format($thanh_tien, 0) }} đ</p>
                                </td>
                            </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Thực thu</p>
                            </td>
                            <td class="tableitem text-end">
                                <p class="itemtext">{{ number_format($thanh_tien, 0) }} đ</p>
                                <p class="itemtext">{{ $tt_chu }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <p class="legal"><strong>Thank you for your business!</strong>
                </p>
            </div>

        </div>
        <!--End InvoiceBot-->
    </div>
    <!--End Invoice-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
