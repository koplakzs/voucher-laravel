<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Voucher extends Model
{
    use HasFactory;
    protected $primaryKey = "id_voucher";
    protected $keyType = 'string';

    protected $fillable = [
        'id_user', 'exp', 'used', 'id_voucher', 'invoice'
    ];
}
