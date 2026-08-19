<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            List of Companies
        </h2>
    </x-slot>

    <!-- 🌟 这里是我们新加的“魔法 CSS”，专门对付打印预览，保证 100% 隐藏 -->
    <style>
        @media print {
            .hide-on-print {
                display: none !important;
            }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <!-- 成功提示在打印时也会被隐藏 -->
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg font-semibold hide-on-print">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- 顶部按钮区域：加上了 hide-on-print，打印时整个消失 -->
                    <div class="flex justify-between items-center mb-6 hide-on-print">
                        <div class="flex gap-2">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded hover:bg-gray-600 transition">
                                ← Close
                            </a>
                            <a href="{{ route('admin.companies.create') }}" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                ➕ Add Company
                            </a>
                        </div>
                        
                        <button onclick="window.print()" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded shadow hover:bg-purple-700 flex items-center gap-2 transition">
                            🖨️ Print
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-xs">
                                    <th class="border border-gray-300 p-3">No.</th>
                                    <th class="border border-gray-300 p-3">Companies Name</th>
                                    <th class="border border-gray-300 p-3">Companies ID</th>
                                    <th class="border border-gray-300 p-3">Address</th>
                                    <th class="border border-gray-300 p-3">Phone</th>
                                    <th class="border border-gray-300 p-3">Person in Charge</th>
                                    <th class="border border-gray-300 p-3 text-center">Photo</th>
                                    <!-- 表头 Action：加上了 hide-on-print，打印时消失 -->
                                    <th class="border border-gray-300 p-3 text-center hide-on-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $index => $company)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 p-3 font-bold">{{ $index + 1 }}</td>
                                        <td class="border border-gray-300 p-3 font-semibold text-blue-600">{{ $company->name }}</td>
                                        <td class="border border-gray-300 p-3 font-mono text-sm">{{ $company->company_number }}</td>
                                        <td class="border border-gray-300 p-3">{{ $company->address }}</td>
                                        <td class="border border-gray-300 p-3">{{ $company->phone }}</td>
                                        <td class="border border-gray-300 p-3">{{ $company->person_in_charge }}</td>
                                        
                                        <td class="border border-gray-300 p-3 text-center">
                                            @if($company->photo)
                                                <img src="{{ asset('storage/' . $company->photo) }}" alt="Photo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin: 0 auto; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">No Photo</span>
                                            @endif
                                        </td>

                                        <!-- 内容 Action 区域：加上了 hide-on-print，打印时彻底消失 -->
                                        <td class="border border-gray-300 p-3 text-center hide-on-print">
                                            <div class="flex justify-center items-center gap-2">
                                                
                                                <a href="{{ route('admin.companies.edit', $company->id) }}" style="background-color: #dbeafe; color: #1e40af; border: 1px solid #1e40af; padding: 4px 12px; border-radius: 4px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block;">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" class="inline-block" onsubmit="return confirm('确定要删除这家公司吗？(Are you sure?)');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>