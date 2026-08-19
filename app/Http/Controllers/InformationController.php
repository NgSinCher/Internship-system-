<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Template; // 🌟 1. 新增：引入 Template 模型
use Illuminate\Http\Request;

class InformationController extends Controller
{
    // 🌟 修改 index 方法：把资讯、规则、还有模板文件全部捞出来
    public function index()
    {
        // 用一个 'type' 字段来区分它们：一个是 info，一个是 rule
        $infoList = Information::where('type', 'info')->latest()->get();
        $rulesList = Information::where('type', 'rule')->latest()->get();
        
        // 🌟 2. 新增：把数据库里所有的模板文件也捞出来
        $templatesList = Template::latest()->get();

        // 🌟 3. 修改：把 $templatesList 一起打包（compact）送到前端页面
        return view('admin.information', compact('infoList', 'rulesList', 'templatesList'));
    }

    // 🌟 修改 store 方法：根据前端传来的 type 存入对应的分类
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:info,rule' // 确保类型只能是 info 或 rule
        ]);

        Information::create([
            'content' => $request->content,
            'type' => $request->type // 存入数据库区分
        ]);

        return redirect()->back()->with('success', 'Posted successfully!');
    }

    // 删除逻辑保持不变，不管是资讯还是规则，只要传过来了 ID 直接干掉
    public function destroy($id)
    {
        Information::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully!');
    }
}