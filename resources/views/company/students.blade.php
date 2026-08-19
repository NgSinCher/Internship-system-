<x-app-layout>
    <div style="background-color: #f8fafc; min-height: 100vh; padding: 40px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; font-family: sans-serif;">
            
            <h2 style="font-size: 24px; font-weight: bold; color: #0f172a; border-bottom: 3px solid #f59e0b; padding-bottom: 10px; margin-bottom: 30px;">
                🏢 Company Supervisor Dashboard - Intern Logs & Final Evaluation
            </h2>

            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px; border: 1px solid #34d399;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px; border: 1px solid #ef4444;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @forelse($allocations as $allocation)
                <div style="background-color: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 50px; border: 1px solid #cbd5e1;">
                    
                    <div style="background-color: #1e293b; color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #f59e0b;">
                        <div>
                            <h3 style="margin: 0; font-size: 20px; color: #f8fafc;">🎓 Intern: <strong>{{ $allocation->student->name ?? 'Unknown Student' }}</strong></h3>
                            <p style="margin: 5px 0 0 0; color: #94a3b8; font-size: 13px;">Staff/Student ID: {{ $allocation->student->email ?? 'N/A' }}</p>
                        </div>
                        <div style="background-color: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 6px; font-size: 12px; font-weight: bold; color: #f59e0b;">
                            TOTAL LOGS: {{ $allocation->logBooks->count() }}
                        </div>
                    </div>

                    <div style="background-color: #f1f5f9; padding: 18px 30px; border-bottom: 1px solid #cbd5e1; font-size: 13px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                        <div><span style="color: #64748b; font-weight: bold;">Programme:</span> <span style="color: #0f172a; font-weight: 600;">Information Technology</span></div>
                        <div><span style="color: #64748b; font-weight: bold;">Lecturer Supervisor:</span> <span style="color: #2563eb; font-weight: 600;">{{ $allocation->lecturer->name ?? 'Assigned by Faculty' }}</span></div>
                        <div><span style="color: #64748b; font-weight: bold;">Intern Email:</span> <span style="color: #0f172a;">{{ $allocation->student->email ?? 'N/A' }}</span></div>
                        <div><span style="color: #64748b; font-weight: bold;">Contact Phone:</span> <span style="color: #0f172a;">+60 (Student Registered)</span></div>
                    </div>

                    <div style="padding: 25px 30px;">
                        <h4 style="margin: 0 0 15px 0; color: #334155; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                            <span>📑</span> Weekly Activity Logs Review
                        </h4>

                        @forelse($allocation->logBooks as $log)
                            <div style="background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 15px; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 20px;">
                                
                                <div style="flex: 2; min-width: 300px;">
                                    <div style="font-size: 12px; color: #64748b; font-weight: bold; margin-bottom: 8px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                                        <span>📅 Date: {{ $log->date }}</span>
                                        <span>⏱️ Hours: {{ $log->working_hours }}h</span>
                                        <span>
                                            Status: 
                                            @if($log->status === 'pending') <strong style="color: #d97706;">🟡 PENDING</strong>
                                            @elseif($log->status === 'approved') <strong style="color: #059669;">🟢 APPROVED</strong>
                                            @else <strong style="color: #dc2626;">🔴 REJECTED</strong>
                                            @endif
                                        </span>
                                        
                                        @if(!empty($log->report_path))
                                            <a href="{{ asset('storage/' . $log->report_path) }}" target="_blank" download style="background: #e0e7ff; color: #3730a3; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-size: 11px;">📎 View Attachment</a>
                                        @endif
                                    </div>
                                    <p style="margin: 0; font-size: 14px; color: #334155; line-height: 1.5;">{{ $log->activity_description }}</p>
                                </div>

                                <div style="flex: 1; min-width: 250px; border-left: 2px dashed #cbd5e1; padding-left: 20px;">
                                    <form action="{{ route('company.log.review', $log->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                                        @csrf
                                        <div>
                                            <select name="status" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #cbd5e1; font-weight: bold; color: #1e293b;">
                                                <option value="pending" {{ $log->status == 'pending' ? 'selected' : '' }}>🟡 Keep Pending</option>
                                                <option value="approved" {{ $log->status == 'approved' ? 'selected' : '' }}>🟢 Approve Log</option>
                                                <option value="rejected" {{ $log->status == 'rejected' ? 'selected' : '' }}>🔴 Reject Log</option>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" name="supervisor_remarks" value="{{ $log->supervisor_remarks }}" placeholder="Optional remarks for student..." style="width: 100%; box-sizing: border-box; padding: 8px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 13px;">
                                        </div>
                                        <button type="submit" style="background-color: #0f172a; color: white; border: none; padding: 8px; border-radius: 4px; font-weight: bold; cursor: pointer; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Update Status</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 20px;">Student hasn't submitted any logs yet.</p>
                        @endforelse
                    </div>

                    <div style="background-color: #fffbeb; border-top: 3px solid #f59e0b; padding: 25px 30px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h4 style="margin: 0; color: #b45309; font-size: 17px; font-weight: 900;">🏆 Final Internship Evaluation (100%)</h4>
                            @if($allocation->final_score !== null)
                                <span style="background: #f59e0b; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 900;">Graded: {{ $allocation->final_score }} / 100</span>
                            @endif
                        </div>

                        @php
                            // 解析已保存的打分记录
                            $savedScores = json_decode($allocation->rubric_scores, true) ?? [20, 20, 20, 20, 20];
                        @endphp

                        <form action="{{ route('company.evaluate.store', $allocation->id) }}" method="POST">
                            @csrf
                            <table style="width: 100%; border-collapse: collapse; text-align: left; background: white; border: 1px solid #fcd34d; border-radius: 8px; overflow: hidden; font-size: 13px; margin-bottom: 15px;">
                                <thead>
                                    <tr style="background: #fef3c7; color: #92400e; border-bottom: 1px solid #fcd34d;">
                                        <th style="padding: 10px 15px; width: 60px;">No.</th>
                                        <th style="padding: 10px 15px;">Assessment Rubric (考核细则项目)</th>
                                        <th style="padding: 10px 15px; width: 140px; text-align: right;">Points (Max 20)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid #fef3c7;">
                                        <td style="padding: 10px 15px; font-weight: bold; color: #94a3b8;">1</td>
                                        <td style="padding: 10px 15px; font-weight: 600; color: #334155;">Work Attitude & Professional Discipline (工作态度与纪律)</td>
                                        <td style="padding: 10px 15px; text-align: right;"><input type="number" name="scores[0]" value="{{ $savedScores[0] ?? 20 }}" min="0" max="20" required style="width: 80px; padding: 4px; text-align: center; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #fef3c7;">
                                        <td style="padding: 10px 15px; font-weight: bold; color: #94a3b8;">2</td>
                                        <td style="padding: 10px 15px; font-weight: 600; color: #334155;">Technical Competency & Task Execution (技术能力与执行力)</td>
                                        <td style="padding: 10px 15px; text-align: right;"><input type="number" name="scores[1]" value="{{ $savedScores[1] ?? 20 }}" min="0" max="20" required style="width: 80px; padding: 4px; text-align: center; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #fef3c7;">
                                        <td style="padding: 10px 15px; font-weight: bold; color: #94a3b8;">3</td>
                                        <td style="padding: 10px 15px; font-weight: 600; color: #334155;">Communication & Teamwork Skills (沟通表达与团队合作)</td>
                                        <td style="padding: 10px 15px; text-align: right;"><input type="number" name="scores[2]" value="{{ $savedScores[2] ?? 20 }}" min="0" max="20" required style="width: 80px; padding: 4px; text-align: center; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #fef3c7;">
                                        <td style="padding: 10px 15px; font-weight: bold; color: #94a3b8;">4</td>
                                        <td style="padding: 10px 15px; font-weight: 600; color: #334155;">Problem Solving & Learning Ability (解决问题与自学能力)</td>
                                        <td style="padding: 10px 15px; text-align: right;"><input type="number" name="scores[3]" value="{{ $savedScores[3] ?? 20 }}" min="0" max="20" required style="width: 80px; padding: 4px; text-align: center; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;"></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #fef3c7;">
                                        <td style="padding: 10px 15px; font-weight: bold; color: #94a3b8;">5</td>
                                        <td style="padding: 10px 15px; font-weight: 600; color: #334155;">Quality of Final Work & Punctuality (成果质量与守时度)</td>
                                        <td style="padding: 10px 15px; text-align: right;"><input type="number" name="scores[4]" value="{{ $savedScores[4] ?? 20 }}" min="0" max="20" required style="width: 80px; padding: 4px; text-align: center; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="display: flex; gap: 15px; align-items: center;">
                                <input type="text" name="final_comments" value="{{ $allocation->final_comments }}" placeholder="Overall performance comments for university record..." style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
                                <button type="submit" style="background-color: #d97706; color: white; border: none; padding: 10px 25px; border-radius: 6px; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; font-size: 12px; shrink-0;">
                                    Submit Evaluation (提交评分)
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            @empty
                <div style="text-align: center; padding: 50px; background-color: white; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 40px;">📭</span>
                    <h3 style="color: #64748b;">No interns assigned to you yet.</h3>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>