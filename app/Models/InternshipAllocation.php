<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipAllocation extends Model
{
    use HasFactory;

    // 🌟 终极解印：用这一行，把原本几十行的 fillable 白名单直接废除！
    // 意思是：本模型没有任何黑名单字段，以后你不管往表里加什么新数据，一律准许入库！
    protected $guarded = []; 

    // 呼叫 .student 就能拿到该 User 的资料
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // 呼叫 .company 就能拿到该 Company 的资料
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // 呼叫 .companySupervisor 就能拿到业界主管的资料
    public function companySupervisor()
    {
        return $this->belongsTo(User::class, 'company_sv_id');
    }

    // 呼叫 .lecturer 就能拿到学校讲师的资料
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_sv_id');
    }

    public function logBooks()
    {
        return $this->hasMany(LogBook::class, 'internship_allocation_id');
    }
}