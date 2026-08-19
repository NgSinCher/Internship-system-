<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
        $role = $user->role;
        $announcements = \Schema::hasTable('announcements') ? \App\Models\Announcement::latest()->get() : [];
        $totalUsers = \App\Models\User::count();
        $totalAllocations = \Schema::hasTable('internship_allocations') ? \App\Models\InternshipAllocation::count() : 0;
        
        $logTotal = 0; $logPending = 0; $logApproved = 0;
        if(isset($myAllocation) && $myAllocation && \Schema::hasTable('log_books')){
            $logTotal = \App\Models\LogBook::where('internship_allocation_id', $myAllocation->id)->count();
            $logPending = \App\Models\LogBook::where('internship_allocation_id', $myAllocation->id)->where('status', 'pending')->count();
            $logApproved = \App\Models\LogBook::where('internship_allocation_id', $myAllocation->id)->where('status', 'approved')->count();
        }
        $lecStudentCount = ($role === 'lecturer' && \Schema::hasTable('internship_allocations')) ? \App\Models\InternshipAllocation::where('lecturer_sv_id', $user->id)->count() : 0;
        $comStudentCount = 0; $comPendingLogs = 0;
        if($role === 'company_sv' && \Schema::hasTable('internship_allocations')){
            $allocations = \App\Models\InternshipAllocation::where('company_sv_id', $user->id)->get();
            $comStudentCount = $allocations->count();
            foreach($allocations as $alloc){
                $comPendingLogs += \App\Models\LogBook::where('internship_allocation_id', $alloc->id)->where('status', 'pending')->count();
            }
        }
    @endphp

    <div style="background-color: #f1f5f9; min-height: calc(100vh - 65px); padding: 40px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; font-family: sans-serif;">
            
            <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 16px; padding: 30px; color: white; margin-bottom: 30px;">
                <h1 style="font-size: 28px; font-weight: 900;">Welcome back, {{ $user->name }}! 👋</h1>
            </div>

            @foreach($announcements as $ann)
                <div style="background-color: #eff6ff; border-left: 6px solid #3b82f6; padding: 20px; border-radius: 12px; margin-bottom: 15px;">
                    <h4 style="margin: 0; color: #1e40af; font-weight: 900;">📢 {{ $ann->title }}</h4>
                    <p style="margin: 5px 0 0 0; color: #334155;">{{ $ann->content }}</p>
                </div>
            @endforeach

            @if($role === 'admin')
                <div style="background-color: white; padding: 25px; border-radius: 16px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
                    <h3 style="font-weight: 900; margin-bottom: 15px;">Post New Announcement</h3>
                    <form action="{{ url('/announcements') }}" method="POST" style="display: flex; gap: 10px;">
                        @csrf
                        <input type="text" name="title" placeholder="Title" required style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; flex: 1;">
                        <input type="text" name="content" placeholder="Content" required style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; flex: 2;">
                        <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">Publish</button>
                    </form>
                </div>

                <div style="background-color: white; padding: 25px; border-radius: 16px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                    <h3 style="font-weight: 900; margin-bottom: 15px;">📋 Announcement History</h3>
                    @if($announcements->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 20px 0;">No announcements published yet.</p>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b;">
                                        <th style="padding: 12px 8px;">Title</th>
                                        <th style="padding: 12px 8px;">Content</th>
                                        <th style="padding: 12px 8px;">Date</th>
                                        <th style="padding: 12px 8px; text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $ann)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 12px 8px; font-weight: bold; color: #1e293b;">{{ $ann->title }}</td>
                                            <td style="padding: 12px 8px; color: #64748b;">{{ \Illuminate\Support\Str::limit($ann->content, 60) }}</td>
                                            <td style="padding: 12px 8px; color: #94a3b8;">{{ $ann->created_at->format('Y-m-d H:i') }}</td>
                                            <td style="padding: 12px 8px; text-align: right;">
                                                <a href="{{ route('announcements.edit', $ann->id) }}" style="color: #3b82f6; font-weight: bold; margin-right: 15px; text-decoration: none;">Edit</a>
                                                <form action="{{ route('announcements.destroy', $ann->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" style="color: #ef4444; font-weight: bold; background: none; border: none; cursor: pointer; padding: 0;">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div style="background: white; padding: 25px; border-radius: 12px; border-top: 4px solid #3b82f6;">
                        <div style="color: #64748b; font-weight: bold;">Total Users</div>
                        <div style="font-size: 32px; font-weight: 900;">{{ $totalUsers }}</div>
                    </div>
                </div>
            @endif

            @if($role === 'student')
                <div style="background: white; padding: 25px; border-radius: 16px; margin-bottom: 25px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        <h3 style="font-weight: 900; font-size: 18px; color: #0f172a; margin: 0;">👤 My Placement Details (Show Information Only)</h3>
                        <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">Active Intern</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; font-size: 14px;">
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Full Name:</span> <strong style="color: #1e293b;">{{ $user->name }}</strong></div>
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Student ID / Email:</span> <strong style="color: #1e293b;">{{ $user->email }}</strong></div>
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Programme:</span> <strong style="color: #1e293b;">Information Technology (SUC)</strong></div>
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Internship Company Name:</span> <strong style="color: #2563eb;">{{ $myAllocation->company->name ?? 'Pending Allocation' }}</strong></div>
                        <div style="grid-column: 1 / -1;"><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Company Address:</span> <strong style="color: #334155;">{{ $myAllocation->company->address ?? 'Johor Bahru Region, Malaysia' }}</strong></div>
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Company Supervisor:</span> <strong style="color: #059669;">{{ $myAllocation->company_sv->name ?? 'Assigned by Company' }}</strong></div>
                        <div><span style="color: #64748b; display: block; font-size: 12px; font-weight: bold;">Lecturer Supervisor:</span> <strong style="color: #7c3aed;">{{ $myAllocation->lecturer->name ?? 'Assigned by Faculty' }}</strong></div>
                    </div>
                </div>

                <div style="background: white; padding: 25px; border-radius: 16px; margin-bottom: 25px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-weight: 900; font-size: 18px; color: #0f172a; margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <span>📢</span> Official Internship Information & Downloads
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                        
                        <div style="background: #f8fafc; padding: 18px; border-radius: 12px; border: 1px solid #f1f5f9;">
                            <h4 style="margin: 0 0 12px 0; color: #2563eb; font-size: 15px; font-weight: 800;">💡 Internship Memos & Rules</h4>
                            <ul style="margin: 0; padding-left: 20px; color: #334155; font-size: 13px; line-height: 1.6;">
                                @forelse($infoList as $info)
                                    <li style="margin-bottom: 6px;">{{ $info->content }}</li>
                                @empty
                                    <li style="color: #94a3b8; list-style: none; margin-left: -20px;">No general information posted.</li>
                                @endforelse

                                @foreach($rulesList as $rule)
                                    <li style="margin-bottom: 6px; color: #9333ea; font-weight: 600;">[Rule] {{ $rule->content }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div style="background: #ecfdf5; padding: 18px; border-radius: 12px; border: 1px solid #d1fae5;">
                            <h4 style="margin: 0 0 12px 0; color: #059669; font-size: 15px; font-weight: 800;">⬇️ Forms & Templates Download</h4>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                @forelse($templatesList as $tpl)
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 10px 14px; border-radius: 8px; border: 1px solid #a7f3d0;">
                                        <span style="font-size: 13px; font-weight: bold; color: #065f46;">📄 {{ $tpl->title }}</span>
                                        <a href="{{ asset('storage/' . $tpl->file_path) }}" target="_blank" download style="background: #059669; color: white; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">Download</a>
                                    </div>
                                @empty
                                    <p style="margin: 0; font-size: 13px; color: #6e798c; font-style: italic;">No templates uploaded yet.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #10b981; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <div style="color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase;">Approved Weekly Logs</div>
                        <div style="font-size: 24px; font-weight: 900; color: #059669; margin-top: 5px;">{{ $logApproved }}</div>
                    </div>
                    <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #f59e0b; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <div style="color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase;">Pending Logs</div>
                        <div style="font-size: 24px; font-weight: 900; color: #d97706; margin-top: 5px;">{{ $logPending }}</div>
                    </div>
                </div>
            @endif

            @if($role === 'lecturer')
                @php
                    $myStudents = \Schema::hasTable('internship_allocations') 
                        ? \App\Models\InternshipAllocation::with(['student', 'company'])->where('lecturer_sv_id', $user->id)->get() 
                        : collect([]);
                    
                    $totalStudents = $myStudents->count();
                    $gradedStudents = $myStudents->whereNotNull('total_weighted_score')->count();
                    $pendingStudents = $myStudents->whereNull('total_weighted_score')->count();
                @endphp

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    
                    <div style="background: white; padding: 22px; border-radius: 12px; border-top: 4px solid #6366f1; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                        <div style="color: #64748b; font-size: 13px; font-weight: bold; text-transform: uppercase;">指导学生总数</div>
                        <div style="font-size: 32px; font-weight: 900; color: #1e1b4b; margin-top: 5px;">{{ $totalStudents }} <span style="font-size: 14px; color: #94a3b8; font-weight: normal;">人</span></div>
                    </div>

                    <div style="background: white; padding: 22px; border-radius: 12px; border-top: 4px solid #10b981; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                        <div style="color: #64748b; font-size: 13px; font-weight: bold; text-transform: uppercase;">已完成加权终评</div>
                        <div style="font-size: 32px; font-weight: 900; color: #065f46; margin-top: 5px;">{{ $gradedStudents }} <span style="font-size: 14px; color: #94a3b8; font-weight: normal;">人</span></div>
                    </div>

                    <div style="background: white; padding: 22px; border-radius: 12px; border-top: 4px solid #f59e0b; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                        <div style="color: #64748b; font-size: 13px; font-weight: bold; text-transform: uppercase;">待处理学分终评</div>
                        <div style="font-size: 32px; font-weight: 900; color: #9a3412; margin-top: 5px; display: flex; align-items: center; gap: 10px;">
                            <span>{{ $pendingStudents }}</span>
                            @if($pendingStudents > 0)
                                <span style="background: #fee2e2; color: #ef4444; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: bold;">Action Required</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div style="background-color: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                        <h3 style="font-weight: 900; margin: 0; color: #1e293b; font-size: 18px; display: flex; align-items: center; gap: 8px;">
                            <span>📋</span> Supervised Students Progress Roster
                        </h3>
                        <a href="{{ route('lecturer.students.index') }}" style="background: #6366f1; color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; text-decoration: none;">进入评分页 →</a>
                    </div>

                    @if($myStudents->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 30px 0; font-style: italic;">目前暂无分配给您的实习学生。</p>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0; color: #475569; background-color: #f8fafc;">
                                        <th style="padding: 12px 10px;">Student Name</th>
                                        <th style="padding: 12px 10px;">Company</th>
                                        <th style="padding: 12px 10px; text-align: center;">Company SV (30%)</th>
                                        <th style="padding: 12px 10px; text-align: center;">Lecturer SV (70%)</th>
                                        <th style="padding: 12px 10px; text-align: center;">Total Score</th>
                                        <th style="padding: 12px 10px; text-align: right;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myStudents as $studentAlloc)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 14px 10px;">
                                                <strong style="color: #1e293b; font-size: 14px;">{{ $studentAlloc->student->name ?? 'N/A' }}</strong>
                                                <span style="display: block; font-size: 11px; color: #94a3b8;">{{ $studentAlloc->student->email ?? '' }}</span>
                                            </td>
                                            <td style="padding: 14px 10px; color: #475569; font-weight: 600;">
                                                🏢 {{ $studentAlloc->company->name ?? 'Pending' }}
                                            </td>
                                            <td style="padding: 14px 10px; text-align: center;">
                                                @if($studentAlloc->final_score !== null)
                                                    <span style="color: #d97706; font-weight: bold;">{{ $studentAlloc->final_score }} pts</span>
                                                    <span style="display:block; font-size:10px; color:#94a3b8;">({{ $studentAlloc->final_score * 0.3 }}%)</span>
                                                @else
                                                    <span style="color: #94a3b8; font-style: italic;">Not Graded</span>
                                                @endif
                                            </td>
                                            <td style="padding: 14px 10px; text-align: center;">
                                                @if($studentAlloc->lecturer_score !== null)
                                                    <span style="color: #2563eb; font-weight: bold;">{{ $studentAlloc->lecturer_score }} pts</span>
                                                    <span style="display:block; font-size:10px; color:#94a3b8;">({{ $studentAlloc->lecturer_score * 0.7 }}%)</span>
                                                @else
                                                    <span style="color: #ef4444; font-weight: bold; background: #fee2e2; padding: 2px 6px; border-radius: 4px; font-size: 11px;">Pending Input</span>
                                                @endif
                                            </td>
                                            <td style="padding: 14px 10px; text-align: center; font-size: 15px;">
                                                @if($studentAlloc->total_weighted_score !== null)
                                                    <strong style="color: #059669;">{{ $studentAlloc->total_weighted_score }}%</strong>
                                                @else
                                                    <span style="color: #94a3b8; font-weight: bold;">Incomplete</span>
                                                @endif
                                            </td>
                                            <td style="padding: 14px 10px; text-align: right;">
                                                @if($studentAlloc->total_weighted_score !== null)
                                                    <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 11px;">🟢 PASSED</span>
                                                @else
                                                    <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 11px;">⏳ ONGOING</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

            @if($role === 'company_sv')
                <div style="background: white; padding: 25px; border-radius: 12px; border-top: 4px solid #f59e0b;">
                    <h3 style="font-weight: 900;">Pending Logs to Review</h3>
                    <p style="font-size: 32px; font-weight: 900; color: #ef4444;">{{ $comPendingLogs }}</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>