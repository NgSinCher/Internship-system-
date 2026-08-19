<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Internship Allocation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-lg font-semibold shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>🔗</span> Assign Intern to Company & Supervisors
                </h3>

                <form action="{{ route('admin.allocate.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">1. Select Student:</label>
                        <select name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            <option value="">-- Choose a Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_staff_id ?? 'No ID' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">2. Select Company:</label>
                        <select name="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            <option value="">-- Choose a Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">3. Company Supervisor (Industry):</label>
                        <select name="company_sv_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            <option value="">-- Choose Company SV --</option>
                            @foreach($companySvs as $sv)
                                <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">4. Lecturer Supervisor (SUC):</label>
                        <select name="lecturer_sv_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            <option value="">-- Choose Lecturer --</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">5. Internship Duration:</label>
                        <input type="text" name="duration" placeholder="e.g., 3 Months, 12 Weeks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                    </div>

                    <div class="col-span-1 md:col-span-2 flex justify-end mt-2">
                        <button type="submit" 
                                style="background-color: #2563eb !important; color: white !important;" 
                                class="px-6 py-2.5 rounded-md font-bold text-xs uppercase tracking-widest shadow-md hover:opacity-90 cursor-pointer">
                            Confirm Allocation
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>📋</span> Current Active Allocations
                </h3>

                <div class="overflow-x-auto">
                   <table class="w-full text-left border-collapse border border-gray-200">
    <thead>
        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
            <th class="p-3 border">Student</th>
            <th class="p-3 border">Company</th>
            <th class="p-3 border">Company SV</th>
            <th class="p-3 border">Lecturer SV</th>
            <th class="p-3 border">Duration</th>
            <th class="p-3 border text-center">Status</th>
            <th class="p-3 border text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($allocations as $item)
            <tr class="hover:bg-gray-50 text-sm">
                <td class="p-3 border font-bold text-gray-900">{{ $item->student->name ?? 'N/A' }}</td>
                <td class="p-3 border text-blue-600 font-semibold">{{ $item->company->name ?? 'N/A' }}</td>
                <td class="p-3 border">{{ $item->companySupervisor->name ?? 'N/A' }}</td>
                <td class="p-3 border">{{ $item->lecturer->name ?? 'N/A' }}</td>
                <td class="p-3 border text-gray-700">{{ $item->duration ?? '-' }}</td>
                <td class="p-3 border text-center">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Linked</span>
                </td>
                
                <td class="p-3 border text-center">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                        
                        <a href="{{ route('admin.allocate.edit', $item->id) }}" 
                           style="background-color: #eab308 !important; color: #ffffff !important; padding: 4px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; font-size: 12px; display: inline-block;">
                           Edit
                        </a>

                        <form action="{{ route('admin.allocate.destroy', $item->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('确定要解除分配吗？(Are you sure?)');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background-color: #dc2626 !important; color: #ffffff !important; padding: 4px 12px; border-radius: 4px; font-weight: bold; border: none; cursor: pointer; font-size: 12px;">
                                Delete
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-8 text-center text-gray-400 italic">
                    No students have been assigned yet.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>