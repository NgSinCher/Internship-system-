<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📢 Internship Info, Rules & Templates Center
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #f1f5f9; min-height: calc(100vh - 65px);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            @if(session('success'))
                <div class="col-span-1 md:col-span-3 p-4 bg-green-100 text-green-800 rounded-lg font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="col-span-1 md:col-span-3 p-4 bg-red-100 text-red-800 rounded-lg font-semibold shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6 h-fit">
                
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                    <h3 class="font-bold text-base mb-4 text-gray-800 flex items-center gap-2"><span>✍️</span> Post Text Content</h3>
                    <form action="{{ route('admin.info.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <select name="type" class="w-full border-gray-300 rounded-md shadow-sm p-2 bg-gray-50 text-sm" required>
                                <option value="info">💡 Information (资讯)</option>
                                <option value="rule">📜 Rules & Regulations (规则)</option>
                            </select>
                        </div>
                        <div>
                            <textarea name="content" class="w-full border-gray-300 rounded-md shadow-sm p-2 text-sm" rows="4" placeholder="Type content here..." required></textarea>
                        </div>
                        <button type="submit" style="background-color: #2563eb !important; color: white !important;" class="w-full py-2 rounded font-bold text-xs uppercase tracking-widest shadow hover:opacity-90 transition cursor-pointer">Publish Text</button>
                    </form>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                    <h3 class="font-bold text-base mb-4 text-emerald-700 flex items-center gap-2"><span>📎</span> Attachment / Template Upload</h3>
                    
                    <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                            <div class="flex justify-between items-center text-xs font-bold text-gray-700">
                                <span>1. Daily Logbook Template</span>
                                <span class="text-emerald-600">[Required]</span>
                            </div>
                            <input type="hidden" name="title" value="Daily Logbook Template">
                            <div class="flex gap-2">
                                <input type="file" name="file" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-emerald-100 file:text-emerald-800" required>
                                <button type="submit" style="background-color: #059669 !important; color: white !important;" class="px-3 py-1 rounded text-xs font-bold shrink-0 cursor-pointer">Upload</button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 mt-3">
                        @csrf
                        
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                            <div class="flex justify-between items-center text-xs font-bold text-gray-700">
                                <span>2. Company Acceptance Form</span>
                                <span class="text-blue-600">[Official]</span>
                            </div>
                            <input type="hidden" name="title" value="Company Acceptance Form">
                            <div class="flex gap-2">
                                <input type="file" name="file" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-blue-100 file:text-blue-800" required>
                                <button type="submit" style="background-color: #2563eb !important; color: white !important;" class="px-3 py-1 rounded text-xs font-bold shrink-0 cursor-pointer">Upload</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white p-5 shadow-sm sm:rounded-lg border border-gray-200">
                    <h3 class="font-bold text-base mb-3 text-blue-600 flex items-center gap-2"><span>💡</span> Active Information</h3>
                    <table class="w-full text-left border border-gray-100 text-sm">
                        <tbody>
                            @forelse($infoList as $info)
                                <tr class="border-b hover:bg-gray-50"><td class="p-3 text-gray-700">{{ $info->content }}</td><td class="p-3 text-right w-20"><form action="{{ route('admin.info.destroy', $info->id) }}" method="POST" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button style="color: #dc2626 !important;" class="text-xs font-bold underline bg-transparent border-0 cursor-pointer p-0">Delete</button></form></td></tr>
                            @empty <tr><td class="p-4 text-center text-gray-400 italic text-xs">No info posted.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-5 shadow-sm sm:rounded-lg border border-gray-200">
                    <h3 class="font-bold text-base mb-3 text-purple-600 flex items-center gap-2"><span>📜</span> Rules & Regulations</h3>
                    <table class="w-full text-left border border-gray-100 text-sm">
                        <tbody>
                            @forelse($rulesList as $rule)
                                <tr class="border-b hover:bg-gray-50"><td class="p-3 text-gray-700">{{ $rule->content }}</td><td class="p-3 text-right w-20"><form action="{{ route('admin.info.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button style="color: #dc2626 !important;" class="text-xs font-bold underline bg-transparent border-0 cursor-pointer p-0">Delete</button></form></td></tr>
                            @empty <tr><td class="p-4 text-center text-gray-400 italic text-xs">No rules posted.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-5 shadow-sm sm:rounded-lg border border-emerald-200">
                    <h3 class="font-bold text-base mb-3 text-emerald-700 flex items-center gap-2"><span>⬇️</span> Downloadable Templates & Attachments</h3>
                    <table class="w-full text-left border border-gray-100 text-sm">
                        <tbody>
                            @forelse($templatesList as $template)
                                <tr class="border-b hover:bg-emerald-50/30 transition">
                                    <td class="p-3 font-semibold text-gray-800 flex items-center gap-2">
                                        <span>📄</span> {{ $template->title }}
                                    </td>
                                    <td class="p-3 text-right space-x-3 w-44">
                                        <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank" download class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded text-xs font-bold hover:bg-emerald-200 transition no-underline">
                                            Download
                                        </a>
                                        <form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this file?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="color: #dc2626 !important;" class="text-xs font-bold underline bg-transparent border-0 cursor-pointer p-0">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty <tr><td class="p-4 text-center text-gray-400 italic text-xs">No templates uploaded yet.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>