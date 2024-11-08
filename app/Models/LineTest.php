<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LineTest extends Model
{
    use HasFactory;
    // 禁用自動時間戳

    protected $table = 'msgdata';
    public $timestamps = false;

    protected $fillable = [
        'messages',
        'time',
    ];
}
