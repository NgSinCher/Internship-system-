<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 💡 新增：用来操作文件删除

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies', compact('companies'));
    }

    public function create()
    {
        return view('admin.create_company');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_number' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:50',
            'person_in_charge' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('companies', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')->with('success', 'New company added successfully!');
    }

    // ==========================================
    // 🌟 往下是今天刚加的新功能：编辑、更新、删除
    // ==========================================

    // 1. 显示“编辑公司”的表单画面
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.edit_company', compact('company'));
    }

    // 2. 接收编辑后的数据并保存
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_number' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:50',
            'person_in_charge' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = Company::findOrFail($id);
        $data = $request->except('photo');

        // 如果用户上传了新照片
        if ($request->hasFile('photo')) {
            // 先把旧照片从服务器删掉，节省空间
            if ($company->photo) {
                Storage::disk('public')->delete($company->photo);
            }
            // 存入新照片
            $data['photo'] = $request->file('photo')->store('companies', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully!');
    }

    // 3. 删除公司
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // 如果有照片，顺便把照片文件也删干净
        if ($company->photo) {
            Storage::disk('public')->delete($company->photo);
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully!');
    }
}