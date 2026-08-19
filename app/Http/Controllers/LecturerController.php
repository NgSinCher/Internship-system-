<?php

namespace App\Http\Controllers;

use App\Models\InternshipAllocation;
use App\Models\LogBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    // 1. 讲师查看归自己管的学生名册，以及他们的日记
    public function index()
    {
        $allocations = InternshipAllocation::with(['student', 'company', 'logBooks' => function($q) {
            $q->orderBy('date', 'desc');
        }])
        ->where('lecturer_sv_id', Auth::id())
        ->get();

        return view('lecturer.students', compact('allocations'));
    }

    // 2. 🌟 核心重构：实现 30%老板 + 70%老师 = 终极加权分 🌟
    public function grade(Request $request, $id)
    {
        $allocation = InternshipAllocation::where('lecturer_sv_id', Auth::id())->findOrFail($id);

        $request->validate([
            'lecturer_score' => 'required|numeric|min:0|max:100', // 注意前端表单传过来的得叫 lecturer_score
            'lecturer_feedback' => 'nullable|string',
        ]);

        // 1. 提取双边分数 (如果老板还没打分，默认当0分算)
        $companyScore  = $allocation->final_score ?? 0; 
        $lecturerScore = $request->lecturer_score;

        // 2. 🌟 严格代入你手绘草图上的加权公式：(老板×30%) + (老师×70%)
        $weightedCompany = $companyScore * 0.3;
        $weightedLecturer = $lecturerScore * 0.7;
        $grandTotal = round($weightedCompany + $weightedLecturer, 2); // 四舍五入保留两位小数

        // 3. 及格线标准：终极加权分 >= 50 算 passed
        $status = $grandTotal >= 50 ? 'passed' : 'failed';

        // 4. 各归各位，互不冲突！
        $allocation->update([
            'lecturer_score'       => $lecturerScore,
            'lecturer_feedback'    => $request->lecturer_feedback,
            'total_weighted_score' => $grandTotal,
            'grade_status'         => $status,
        ]);

        // 5. 顺手把该生名下所有 Pending 日志一键批准
        LogBook::where('internship_allocation_id', $allocation->id)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Graded! Total Weighted Score: ' . $grandTotal . '% (' . strtoupper($status) . ')');
    }
}