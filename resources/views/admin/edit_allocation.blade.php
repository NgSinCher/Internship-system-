<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Edit Internship Allocation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg font-semibold shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    Update Allocation Details for {{ $allocation->student->name ?? 'Student' }}
                </h3>

                <form action="{{ route('admin.allocate.update', $allocation->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">1. Student:</label>
                        <select name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $allocation->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">2. Company:</label>
                        <select name="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $allocation->company_id == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">3. Company SV:</label>
                        <select name="company_sv_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            @foreach($companySvs as $sv)
                                <option value="{{ $sv->id }}" {{ $allocation->company_sv_id == $sv->id ? 'selected' : '' }}>
                                    {{ $sv->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">4. Lecturer SV:</label>
                        <select name="lecturer_sv_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ $allocation->lecturer_sv_id == $lecturer->id ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">5. Duration:</label>
                        <input type="text" name="duration" value="{{ $allocation->duration }}" placeholder="e.g., 12 Weeks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                    </div>

                    <div class="col-span-1 md:col-span-2 flex justify-end items-center gap-4 mt-4">
                        <a href="{{ route('admin.allocate.index') }}" 
                           class="px-5 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-md text-xs uppercase tracking-widest hover:bg-gray-300 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                style="background-color: #2563eb !important; color: white !important;" 
                                class="px-6 py-2.5 rounded-md font-bold text-xs uppercase tracking-widest shadow-md hover:opacity-90 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>