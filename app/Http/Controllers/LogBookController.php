<?php

namespace App\Http\Controllers;

use App\Models\InternshipAllocation;
use App\Models\LogBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogBookController extends Controller
{
    // 1. 打开日志页面（上半部填表，下半部看历史）
    public function index()
    {
        // 抓出当前登入学生的绑定关系
        $myAllocation = InternshipAllocation::where('student_id', Auth::id())->first();

        if (!$myAllocation) {
            return redirect()->route('dashboard')->with('error', 'You have not been assigned to any company yet!');
        }

        // 捞出他写过的所有日记，按日期倒序（最新的在最上面）
        $logs = LogBook::where('internship_allocation_id', $myAllocation->id)
                    ->orderBy('date', 'desc')
                    ->get();

        return view('student.logbook', compact('myAllocation', 'logs'));
    }

    // 2. 学生点击 Submit 保存日记
    public function store(Request $request)
    {
        $myAllocation = InternshipAllocation::where('student_id', Auth::id())->firstOrFail();

        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'activity_description' => 'required|string',
            'working_hours' => 'required|numeric|min:0.5|max:16',
        ]);

        LogBook::create([
            'internship_allocation_id' => $myAllocation->id,
            'date' => $request->date,
            'activity_description' => $request->activity_description,
            'working_hours' => $request->working_hours,
            'status' => 'pending', // 刚交上去，一律是待审批黄灯
        ]);

        return redirect()->back()->with('success', 'Log Book submitted! Waiting for Company SV approval.');
    }

    // 新增：处理学生上传期末 PDF 报告
    public function uploadReport(Request $request)
    {
        $request->validate([
            'final_report' => 'required|mimes:pdf|max:10240', // 限制只能是 PDF，最大 10MB
        ]);

        // 找到当前登录学生的分配记录
        $allocation = \App\Models\InternshipAllocation::where('student_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();

        if ($request->hasFile('final_report')) {
            // 如果之前传过，先把旧文件删了，省内存
            if ($allocation->final_report_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($allocation->final_report_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($allocation->final_report_path);
            }

            // 把文件存进 storage/app/public/reports 文件夹里
            $path = $request->file('final_report')->store('reports', 'public');
            
            $allocation->update([
                'final_report_path' => $path
            ]);
        }

        return redirect()->back()->with('success', 'Final Report PDF uploaded successfully!');
    }
}
