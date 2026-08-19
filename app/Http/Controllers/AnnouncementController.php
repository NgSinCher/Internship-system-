<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    // 你原本可能已经有的发布功能
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back(); // 发布完回到 Dashboard
    }

    // 👇 1. 补上：跳转到编辑页面的功能
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        // 去寻找 resources/views/announcements/edit.blade.php 这个页面
        return view('announcements.edit', compact('announcement'));
    }

    // 👇 2. 补上：保存更新内容的功能
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 更新完毕后，跳回 Dashboard
        return redirect()->route('dashboard');
    }

    // 👇 3. 补上：删除功能
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        // 删除完毕后，跳回 Dashboard
        return redirect()->route('dashboard');
    }
}