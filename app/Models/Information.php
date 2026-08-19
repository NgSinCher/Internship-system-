<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    // 🌟 指定对应的数据库表名叫 information
    protected $table = 'information';

    // 🌟 白名单：允许写入数据库的字段（把 content 和 type 都放进来）
    protected $fillable = [
        'content',
        'type'
    ];
}