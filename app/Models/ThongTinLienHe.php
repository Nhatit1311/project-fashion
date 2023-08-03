<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinLienHe extends Model
{
    use HasFactory;

    protected $table = 'thong_tin_lien_hes';

    protected $fillable = [
        'ho_lot',
        'ten_khach',
        'ho_va_ten',
        'email',
        'so_dien_thoai',
        'tinh_trang',
        'ghi_chu',
    ];
}
