<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipAllocation;
use App\Models\LogBook;
use Illuminate\Support\Facades\Auth;

class CompanySVController extends Controller
{
    // 1. 老板查看归自己管的实习生、详细资料、日记及打分状态
    public function index()
    {
        // 🌟 修改点1：这里补上了 'lecturer'
        $allocations = InternshipAllocation::with(['student', 'lecturer', 'logBooks' => function($q) {
            $q->orderBy('date', 'desc'); // 日记按最新日期排在前面
        }])
        ->where('company_sv_id', Auth::id())
        ->get();

        return view('company.students', compact('allocations'));
    }

    // 2. 老板审批单篇日记 (Approve 或 Reject) 并写评语
    public function reviewLog(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'supervisor_remarks' => 'nullable|string|max:255'
        ]);

        $log = LogBook::findOrFail($id);

        $allocation = InternshipAllocation::where('id', $log->internship_allocation_id)
                        ->where('company_sv_id', Auth::id())
                        ->firstOrFail();

        $log->update([
            'status' => $request->status,
            'supervisor_remarks' => $request->supervisor_remarks
        ]);

        return redirect()->back()->with('success', 'Log status updated to ' . strtoupper($request->status) . '!');
    }

    // 🌟🌟🌟 修改点2：完整新增了处理100分量化考核打分的方法 🌟🌟🌟
    public function submitEvaluation(Request $request, $id)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0|max:20', // 5个细则，每项满分20
            'final_comments' => 'nullable|string'
        ]);

        $allocation = InternshipAllocation::where('id', $id)
                        ->where('company_sv_id', Auth::id())
                        ->firstOrFail();

        // 自动算总分 (满分100)
        $totalScore = array_sum($request->scores);

        $allocation->update([
            'rubric_scores' => json_encode($request->scores),
            'final_score' => $totalScore,
            'final_comments' => $request->final_comments
        ]);

        return redirect()->back()->with('success', 'Final Evaluation Submitted! Total Score: ' . $totalScore . '/100');
    }
}