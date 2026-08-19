<x-app-layout>
    <div style="background-color: #f1f5f9; min-height: 100vh; padding: 40px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; font-family: sans-serif;">
            
            <h2 style="font-size: 24px; font-weight: bold; color: #1e293b; border-bottom: 3px solid #6366f1; padding-bottom: 10px; margin-bottom: 30px;">
                📝 Daily Log Book & Submissions
            </h2>

            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px; border: 1px solid #34d399;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @php
                $myAllocation = \App\Models\InternshipAllocation::where('student_id', auth()->id())->first();
            @endphp

            @if($myAllocation && $myAllocation->total_weighted_score !== null)
                <div style="background-color: #1e293b; border-radius: 12px; padding: 30px; margin-bottom: 30px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 2px solid {{ $myAllocation->grade_status === 'passed' ? '#10b981' : '#ef4444' }};">
                    <div style="flex: 1; min-width: 250px;">
                        <h3 style="margin: 0 0 10px 0; color: #94a3b8; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; font-weight: 900;">
                            🎉 Final Weighted Internship Result
                        </h3>
                        <p style="margin: 0; font-size: 15px; color: #f8fafc; line-height: 1.6;">
                            <strong style="color: #cbd5e1;">Lecturer Remarks:</strong><br>
                            "{{ $myAllocation->lecturer_feedback ?? 'No additional remarks provided by the lecturer.' }}"
                        </p>
                        
                        <div style="margin-top: 12px; font-size: 12px; color: #94a3b8; background: rgba(255,255,255,0.05); padding: 6px 12px; border-radius: 6px; display: inline-block; border: 1px solid rgba(255,255,255,0.1);">
                            📊 Score Breakdown: Company ({{ ($myAllocation->final_score ?? 0) * 0.3 }}%) + Lecturer ({{ ($myAllocation->lecturer_score ?? 0) * 0.7 }}%)
                        </div>
                    </div>

                    <div style="text-align: right; background-color: rgba(255,255,255,0.05); padding: 20px 30px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                        <div style="font-size: 42px; font-weight: 900; line-height: 1; color: {{ $myAllocation->grade_status === 'passed' ? '#4ade80' : '#f87171' }};">
                            {{ $myAllocation->total_weighted_score }}<span style="font-size: 18px; color: #64748b;">%</span>
                        </div>
                        <div style="margin-top: 8px;">
                            <span style="background-color: {{ $myAllocation->grade_status === 'passed' ? 'rgba(74,222,128,0.2)' : 'rgba(248,113,113,0.2)' }}; color: {{ $myAllocation->grade_status === 'passed' ? '#4ade80' : '#f87171' }}; padding: 6px 16px; border-radius: 20px; font-weight: 900; font-size: 14px; letter-spacing: 3px; text-transform: uppercase;">
                                {{ $myAllocation->grade_status }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                
                <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="background-color: white; border-top: 5px solid #3b82f6; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <h3 style="margin-top: 0; color: #1e3a8a;">✍️ Record Today's Task</h3>
                        <form action="{{ route('student.logbook.store') }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Date</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Hours</label>
                                <input type="number" step="0.5" name="working_hours" value="8" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Description</label>
                                <textarea name="activity_description" rows="4" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" required></textarea>
                            </div>
                            <button type="submit" style="width: 100%; background-color: #3b82f6; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                🚀 Submit Log Entry
                            </button>
                        </form>
                    </div>

                    <div style="background-color: #f0fdf4; border-top: 5px solid #10b981; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <h3 style="margin-top: 0; color: #065f46;">📁 Upload Final Report</h3>

                        <form action="{{ route('student.report.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="final_report" accept=".pdf" style="margin-bottom: 15px; display: block; width: 100%;" required>
                            <button type="submit" style="width: 100%; background-color: #10b981; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                📤 Upload PDF
                            </button>
                        </form>

                        @if($myAllocation && $myAllocation->final_report_path)
                            <div style="margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #10b981; border-radius: 4px; font-size: 12px; text-align: center;">
                                ✅ <a href="{{ asset('storage/' . $myAllocation->final_report_path) }}" target="_blank" style="color: #059669; font-weight: bold;">View Submitted Report</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div style="flex: 2; min-width: 300px; background-color: white; border-top: 5px solid #8b5cf6; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <h3 style="margin-top: 0; color: #4c1d95;">📜 My Submission History</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 10px; text-align: left; font-size: 12px; color: #64748b;">Date / Hrs</th>
                                <th style="padding: 10px; text-align: left; font-size: 12px; color: #64748b;">Description</th>
                                <th style="padding: 10px; text-align: right; font-size: 12px; color: #64748b;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: bold; color: #334155;">{{ $log->date }}<br><span style="color:#94a3b8; font-weight:normal;">{{ $log->working_hours }}h</span></td>
                                    <td style="padding: 15px 10px; font-size: 13px; color: #475569;">{{ $log->activity_description }}</td>
                                    <td style="padding: 15px 10px; text-align: right;">
                                        @if($log->status === 'pending')
                                            <span style="background-color: #fef3c7; color: #b45309; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: bold;">🟡 Pending</span>
                                        @elseif($log->status === 'approved')
                                            <span style="background-color: #d1fae5; color: #047857; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: bold;">🟢 Approved</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8;">No logs submitted yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>