<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Edit Announcement
        </h2>
    </x-slot>

    <div style="background-color: #f1f5f9; min-height: calc(100vh - 65px); padding: 40px 20px;">
        <div style="max-width: 800px; margin: 0 auto; font-family: sans-serif;">
            
            <div style="background-color: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <h3 style="font-weight: 900; margin-bottom: 20px; font-size: 20px; color: #1e293b;">
                    Edit Your Announcement
                </h3>
                
                <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Title</label>
                        <input type="text" name="title" value="{{ $announcement->title }}" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; font-size: 16px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #64748b;">Content</label>
                        <textarea name="content" required style="border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; width: 100%; min-height: 120px; font-size: 16px;">{{ $announcement->content }}</textarea>
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 10px;">
                        <button type="submit" style="background: #3b82f6; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; border: none;">
                            Save Changes
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