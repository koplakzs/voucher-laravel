<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = "invoice";
    protected $keyType = 'string';

    protected $fillable = [
        'id_user', 'total', 'name', 'invoice',
    ];
}
