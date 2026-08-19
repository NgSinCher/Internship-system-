<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏢 Create Company Supervisor
        </h2>
    </x-slot>

    <div style="background-color: #f1f5f9; min-height: calc(100vh - 65px); padding: 40px 20px;">
        <div style="max-width: 800px; margin: 0 auto; font-family: sans-serif;">
            
            <div style="background-color: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <h3 style="font-weight: 900; margin-bottom: 20px; font-size: 20px; color: #1e293b;">
                    Register New Company / Supervisor
                </h3>
                
                <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf
                    
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Company Name</label>
                        <input type="text" name="name" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; font-size: 16px;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Company ID / Number</label>
                        <input type="text" name="company_number" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; font-size: 16px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Address</label>
                        <textarea name="address" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; min-height: 80px; font-size: 16px;"></textarea>
                    </div>

                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Phone</label>
                        <input type="text" name="phone" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; font-size: 16px;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Supervisor (Person in Charge)</label>
                        <input type="text" name="person_in_charge" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; font-size: 16px;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Photo (Upload)</label>
                        <input type="file" name="photo" accept="image/*" style="border: 1px solid #cbd5e1; padding: 10px; border-radius: 8px; width: 100%; font-size: 16px; background-color: #f8fafc;">
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 10px;">
                        <button type="submit" style="background: #3b82f6; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; border: none;">
                            Save Company
                        </button>
                        <a href="{{ route('dashboard') }}" style="color: #64748b; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 1px solid #cbd5e1; text-align: center;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>