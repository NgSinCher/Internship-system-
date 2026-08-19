<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_allocation_id',
        'date',
        'activity_description',
        'working_hours',
        'status',
        'supervisor_remarks',
    ];

    // 呼叫 .allocation 就能反向拿到分配关系
    public function allocation()
    {
        return $this->belongsTo(InternshipAllocation::class, 'internship_allocation_id');
    }
}
