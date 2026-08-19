<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InternshipAllocation;
use App\Models\User;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index()
    {
        // 1. 捞出下拉菜单需要的 4 种角色/数据
        $students = User::where('role', 'student')->get();
        $companies = Company::all();
        $companySvs = User::where('role', 'company_sv')->get();
        $lecturers = User::where('role', 'lecturer')->get();

        // 2. 捞出数据库里“已经绑定成功”的所有历史名册
        $allocations = InternshipAllocation::with(['student', 'company', 'companySupervisor', 'lecturer'])->get();

        return view('admin.allocate', compact('students', 'companies', 'companySvs', 'lecturers', 'allocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'company_sv_id' => 'required|exists:users,id',
            'lecturer_sv_id' => 'required|exists:users,id',
            'duration' => 'required|string|max:255', // 💡 1. 补上了对实习时长的验证
        ]);

        // 使用 updateOrCreate：如果该学生之前绑定过别家公司，直接安全覆盖旧数据，防止报错
        InternshipAllocation::updateOrCreate(
            ['student_id' => $request->student_id],
            [
                'company_id' => $request->company_id,
                'company_sv_id' => $request->company_sv_id,
                'lecturer_sv_id' => $request->lecturer_sv_id,
                'duration' => $request->duration, // 💡 2. 补上了对实习时长的保存
            ]
        );

        return redirect()->back()->with('success', 'Internship allocation saved successfully!');
    }

    // ==========================================
    // 🌟 往下是新加的：编辑、更新、删除分配记录
    // ==========================================

    // 1. 显示编辑页面，并把旧数据传过去
    public function edit($id)
    {
        $allocation = InternshipAllocation::findOrFail($id);
        
        // 把所有的下拉菜单选项也捞出来传过去，方便在编辑时重新选
        $students = User::where('role', 'student')->get();
        $companies = Company::all();
        $companySvs = User::where('role', 'company_sv')->get();
        $lecturers = User::where('role', 'lecturer')->get();

        return view('admin.edit_allocation', compact('allocation', 'students', 'companies', 'companySvs', 'lecturers'));
    }

    // 2. 接收更新后的数据并覆盖保存
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'company_sv_id' => 'required|exists:users,id',
            'lecturer_sv_id' => 'required|exists:users,id',
            'duration' => 'required|string|max:255',
        ]);

        $allocation = InternshipAllocation::findOrFail($id);
        
        $allocation->update([
            'student_id' => $request->student_id,
            'company_id' => $request->company_id,
            'company_sv_id' => $request->company_sv_id,
            'lecturer_sv_id' => $request->lecturer_sv_id,
            'duration' => $request->duration,
        ]);

        return redirect()->route('admin.allocate.index')->with('success', 'Allocation record updated successfully!');
    }

    // 3. 删除记录
    public function destroy($id)
    {
        $allocation = InternshipAllocation::findOrFail($id);
        $allocation->delete();

        return redirect()->back()->with('success', 'Allocation record deleted successfully!');
    }
}