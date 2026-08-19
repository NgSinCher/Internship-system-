<x-app-layout>
    <div style="background-color: #f8fafc; min-height: 100vh; padding: 40px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; font-family: sans-serif;">
            
            <h2 style="font-size: 24px; font-weight: bold; color: #1e293b; border-bottom: 3px solid #3b82f6; padding-bottom: 10px; margin-bottom: 30px;">
                👨‍🏫 Supervised Students & Final Weighted Grading (70%)
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
                <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); overflow: hidden; border: 1px solid #e2e8f0; margin-bottom: 40px;">
                    
                    <div style="background: linear-gradient(90deg, #1e3a8a 0%, #312e81 100%); color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <div>
                            <h3 style="margin: 0; font-size: 22px; font-weight: 900; display: flex; align-items: center; gap: 10px;">
                                🎓 {{ $allocation->student->name ?? 'Unknown Student' }}
                                <span style="background-color: #f59e0b; color: #fff; font-size: 12px; padding: 3px 8px; border-radius: 4px;">{{ $allocation->student->email ?? 'No ID' }}</span>
                            </h3>
                            <p style="margin: 5px 0 0 0; color: #cbd5e1; font-size: 14px;">🏢 Company: <strong>{{ $allocation->company->name ?? 'N/A' }}</strong></p>
                        </div>

                        <div style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 8px; text-align: center; min-width: 160px;">
                            <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #cbd5e1; margin-bottom: 5px;">Total Weighted Score</span>
                            
                            @if($allocation->total_weighted_score !== null)
                                @if($allocation->total_weighted_score >= 50)
                                    <div style="font-size: 26px; font-weight: 900; color: #4ade80; line-height: 1;">{{ $allocation->total_weighted_score }}<span style="font-size: 14px; color: #94a3b8;">%</span></div>
                                    <div style="margin-top: 5px;">
                                        <span style="background-color: rgba(74, 222, 128, 0.2); color: #4ade80; border: 1px solid #4ade80; font-size: 10px; padding: 2px 8px; border-radius: 12px; font-weight: bold; letter-spacing: 1px;">PASSED</span>
                                    </div>
                                @else
                                    <div style="font-size: 26px; font-weight: 900; color: #f87171; line-height: 1;">{{ $allocation->total_weighted_score }}<span style="font-size: 14px; color: #94a3b8;">%</span></div>
                                    <div style="margin-top: 5px;">
                                        <span style="background-color: rgba(248, 113, 113, 0.2); color: #f87171; border: 1px solid #f87171; font-size: 10px; padding: 2px 8px; border-radius: 12px; font-weight: bold; letter-spacing: 1px;">FAILED</span>
                                    </div>
                                @endif
                            @else
                                <div style="margin-top: 10px;">
                                    <span style="color: #fbbf24; font-weight: bold; font-size: 14px;">PENDING GRADING</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="background-color: #f1f5f9; padding: 15px 20px; border-bottom: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-around; text-align: center; font-size: 13px;">
                        <div style="background: white; padding: 8px 15px; border-radius: 6px; border: 1px solid #cbd5e1; flex: 1; min-width: 180px;">
                            <span style="color: #64748b; display: block; font-size: 11px; font-weight: bold;">Company Supervisor (30%)</span>
                            <strong style="font-size: 16px; color: #d97706;">
                                {{ $allocation->final_score !== null ? $allocation->final_score . ' pts (' . ($allocation->final_score * 0.3) . '%)' : 'Not Graded Yet' }}
                            </strong>
                        </div>
                        <div style="display: flex; align-items: center; font-weight: bold; color: #94a3b8;">+</div>
                        <div style="background: white; padding: 8px 15px; border-radius: 6px; border: 1px solid #cbd5e1; flex: 1; min-width: 180px;">
                            <span style="color: #64748b; display: block; font-size: 11px; font-weight: bold;">Lecturer Supervisor (70%)</span>
                            <strong style="font-size: 16px; color: #2563eb;">
                                {{ $allocation->lecturer_score !== null ? $allocation->lecturer_score . ' pts (' . ($allocation->lecturer_score * 0.7) . '%)' : 'Pending Input' }}
                            </strong>
                        </div>
                        <div style="display: flex; align-items: center; font-weight: bold; color: #94a3b8;">=</div>
                        <div style="background: #ecfdf5; padding: 8px 15px; border-radius: 6px; border: 1px solid #6ee7b7; flex: 1; min-width: 180px;">
                            <span style="color: #065f46; display: block; font-size: 11px; font-weight: bold;">Total Final Marks (100%)</span>
                            <strong style="font-size: 16px; color: #059669;">
                                {{ $allocation->total_weighted_score !== null ? $allocation->total_weighted_score . '%' : 'Incomplete' }}
                            </strong>
                        </div>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; padding: 20px; gap: 20px;">
                        
                        <div style="flex: 2; min-width: 300px;">
                            <h4 style="color: #334155; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-top: 0;">📅 Submitted Log Books</h4>
                            <div style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                                @forelse($allocation->logBooks as $log)
                                    <div style="background-color: #f8fafc; border: 1px solid #cbd5e1; border-left: 4px solid #3b82f6; padding: 15px; margin-bottom: 15px; border-radius: 6px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                            <strong style="color: #475569; font-size: 14px;">{{ $log->date }} ({{ $log->working_hours }}h)</strong>
                                            @if($log->status === 'pending')
                                                <span style="background-color: #fef3c7; color: #b45309; font-size: 11px; padding: 3px 8px; border-radius: 12px; font-weight: bold;">🟡 PENDING</span>
                                            @elseif($log->status === 'approved')
                                                <span style="background-color: #d1fae5; color: #047857; font-size: 11px; padding: 3px 8px; border-radius: 12px; font-weight: bold;">🟢 APPROVED</span>
                                            @endif
                                        </div>
                                        <p style="margin: 0; font-size: 14px; color: #334155;">{{ $log->activity_description }}</p>
                                    </div>
                                @empty
                                    <p style="color: #94a3b8; text-align: center; font-style: italic;">No logs submitted yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div style="flex: 1; min-width: 250px; background-color: #f0fdf4; border: 2px solid #bbf7d0; padding: 20px; border-radius: 10px; height: fit-content;">
                            
                            <div style="margin-bottom: 20px;">
                                <h4 style="color: #166534; margin-top: 0; margin-bottom: 10px;">📄 Final Report</h4>
                                @if(!empty($allocation->final_report_path))
                                    <a href="{{ asset('storage/' . $allocation->final_report_path) }}" target="_blank" style="display: block; text-align: center; background-color: #059669; color: white; text-decoration: none; padding: 10px; border-radius: 6px; font-weight: bold;">📥 View PDF Report</a>
                                @else
                                    <div style="text-align: center; background-color: #e2e8f0; color: #64748b; padding: 10px; border-radius: 6px; font-size: 12px;">⚠️ No report uploaded</div>
                                @endif
                            </div>

                            <hr style="border-top: 1px solid #bbf7d0; margin-bottom: 20px;">

                            <form action="{{ route('lecturer.grade.store', $allocation->id) }}" method="POST">
                                @csrf
                                <h4 style="color: #166534; margin-top: 0; margin-bottom: 15px;">⚖️ Faculty Grading (70%)</h4>
                                
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 12px; color: #166534; font-weight: bold; margin-bottom: 5px;">Lecturer Score (0-100 pts):</label>
                                    <input type="number" name="lecturer_score" value="{{ $allocation->lecturer_score }}" min="0" max="100" style="width: 100%; box-sizing: border-box; padding: 10px; border: 2px solid #34d399; border-radius: 6px; font-size: 20px; font-weight: bold; text-align: center; color: #065f46;" placeholder="e.g. 85" required>
                                    <span style="font-size: 11px; color: #059669; display: block; margin-top: 4px;">* This will be weighted at 70% automatically.</span>
                                </div>

                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 12px; color: #166534; font-weight: bold; margin-bottom: 5px;">Lecturer Remarks:</label>
                                    <textarea name="lecturer_feedback" rows="3" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #34d399; border-radius: 6px; font-size: 13px;" placeholder="Add your academic feedback here...">{{ $allocation->lecturer_feedback }}</textarea>
                                </div>

                                <button type="submit" style="width: 100%; background-color: #2563eb; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 13px; font-weight: 900; cursor: pointer; text-transform: uppercase; box-shadow: 0 4px 6px rgba(37,99,235,0.3);">
                                    💾 Calculate & Save Grade
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px solid #cbd5e1;">
                    <p style="color: #64748b; font-size: 16px;">No supervised students assigned to your account yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>