<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create User
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden" style="border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0;">
                <div class="p-6 text-gray-900" style="padding: 40px;">
                    
                    @if(session('success'))
                        <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 25px; border: 1px solid #34d399; display: flex; align-items: center; gap: 10px;">
                            <span>✅</span> {{ session('success') }}
                        </div>
                    @endif

                    <h3 style="margin-top: 0; color: #1e293b; font-size: 22px; font-weight: 900; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 25px;">
                        👤 Add New Account
                    </h3>

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 8px;">Full Name:</label>
                            <input type="text" name="name" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #1e293b; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 8px;">Student/Staff ID:</label>
                            <input type="text" name="user_id" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #1e293b; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 8px;">E-mail:</label>
                            <input type="email" name="email" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #1e293b; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 8px;">Password:</label>
                            <input type="password" name="password" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #1e293b; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'" required>
                        </div>

                        <div style="margin-bottom: 35px;">
                            <label style="display: block; font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 8px;">Role:</label>
                            <select name="role" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 15px; background-color: #f8fafc; color: #0f172a; font-weight: bold; outline: none; cursor: pointer;">
                                <option value="student">🎓 Student</option>
                                <option value="lecturer">👨‍🏫 Lecturer (Supervisor)</option>
                                <option value="company_sv">🏢 Company Supervisor</option>
                            </select>
                        </div>

                        <!-- 强制显形的按钮区 -->
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; padding-top: 25px; border-top: 2px solid #e2e8f0;">
                            
                            <!-- 把 Cancel 换成了能真正跳回后台的 a 标签 -->
                            <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #64748b; font-weight: bold; font-size: 14px; padding: 12px 25px; border: 2px solid #e2e8f0; border-radius: 8px; background-color: white; cursor: pointer;">
                                CANCEL
                            </a>

                            <!-- 巨大的蓝底白字保存按键 -->
                            <button type="submit" style="background-color: #2563eb; color: white; border: none; padding: 14px 35px; border-radius: 8px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3); text-transform: uppercase; letter-spacing: 1px;">
                                💾 Save User
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>