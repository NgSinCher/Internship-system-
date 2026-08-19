<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Company / Supervisor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Company Name:</label>
                            <input type="text" name="name" value="{{ $company->name }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Company ID / Registration No:</label>
                            <input type="text" name="company_number" value="{{ $company->company_number }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Address:</label>
                            <textarea name="address" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>{{ $company->address }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Phone Number:</label>
                            <input type="text" name="phone" value="{{ $company->phone }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Person in Charge (Supervisor):</label>
                            <input type="text" name="person_in_charge" value="{{ $company->person_in_charge }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Photo (Upload new to replace):</label>
                            @if($company->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $company->photo) }}" alt="Current Photo" class="w-16 h-16 object-cover rounded border border-gray-200">
                                </div>
                            @endif
                            <input type="file" name="photo" accept="image/*" class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1 p-1.5 bg-white cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-4">
                            <a href="{{ route('admin.companies.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                CANCEL
                            </a>

                            <button type="submit" 
                                    style="background-color: #2563eb !important; color: #ffffff !important; padding: 8px 24px; border-radius: 6px; font-weight: bold; font-size: 12px;"
                                    class="uppercase tracking-widest shadow hover:opacity-90 cursor-pointer">
                                UPDATE
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>