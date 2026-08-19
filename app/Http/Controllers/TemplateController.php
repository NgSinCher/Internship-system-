<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    // 上传文件
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240', // 最大限制10MB
        ]);

        // 把文件存入硬盘的 public/templates 目录下，并拿到路径
        $path = $request->file('file')->store('templates', 'public');

        Template::create([
            'title'     => $request->title,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Template uploaded successfully!');
    }

    // 删除文件（牛逼点在于：删数据库的同时，把硬盘里的实体PDF也干掉，不占你C盘空间！）
    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        if (Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->delete();
        return redirect()->back()->with('success', 'Template deleted completely!');
    }
}