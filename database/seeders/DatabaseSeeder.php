<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 保留你原本的 Admin 管理员账号
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. 补上：南方大学测试生 (Student)
        User::create([
            'name' => 'Ng Sin Cher',
            'student_staff_id' => 'D240100B',
            'email' => 'sincher@suc.edu.my',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Lee',
            'student_staff_id' => 'D240001A',
            'email' => 'lee@suc.edu.my', // ✅ 已经帮你修正为独立邮箱
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Chow',
            'student_staff_id' => 'D240069B',
            'email' => 'chow@suc.edu.my',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        // 3. 补上：业界公司老板 (Company SV)
        User::create([
            'name' => 'Ali bin Ahmad (TechNova Manager)',
            'student_staff_id' => 'SV-001',
            'email' => 'ali@technova.com',
            'password' => bcrypt('password123'),
            'role' => 'company_sv',
        ]);

        // 补上：Johor Softworks Studio 老板 (SV)
        User::create([
            'name' => 'Tan Li Li (Johor Softworks Manager)',
            'student_staff_id' => 'SV-002',
            'email' => 'tan@johorsoft.com',
            'password' => bcrypt('password123'),
            'role' => 'company_sv',
        ]);

        // 补上：Apex Cyber Security 老板 (SV)
        User::create([
            'name' => 'Suresh Kumar (Apex Manager)',
            'student_staff_id' => 'SV-003',
            'email' => 'suresh@apexcyber.com',
            'password' => bcrypt('password123'),
            'role' => 'company_sv',
        ]);

        // 补上：Shopee Mobile Malaysia 老板 (SV)
        User::create([
            'name' => 'Lee Mei Ling (Shopee Manager)',
            'student_staff_id' => 'SV-004',
            'email' => 'leemeiling@shopee.com.my',
            'password' => bcrypt('password123'),
            'role' => 'company_sv',
        ]);

        // 补上：KPMG IT Advisory 老板 (SV)
        User::create([
            'name' => 'David Beckham (KPMG Manager)',
            'student_staff_id' => 'SV-005',
            'email' => 'david@kpmg.com',
            'password' => bcrypt('password123'),
            'role' => 'company_sv',
        ]);

        // 4. 补上：南方大学监督讲师 (Lecturer)
        User::create([
            'name' => 'Dr. Tan Ah Kow',
            'student_staff_id' => 'LEC-889',
            'email' => 'tan@suc.edu.my',
            'password' => bcrypt('password123'),
            'role' => 'lecturer',
        ]);

        User::create([
            'name' => 'Dr. Eugene Ng',
            'student_staff_id' => 'LEC-911',
            'email' => 'eugene@suc.edu.my',
            'password' => bcrypt('password123'),
            'role' => 'lecturer',
        ]);

        // 5. 完全保留你原本辛苦写好的 5 家公司！
        Company::insert([
            ['name' => 'TechNova Solutions Sdn Bhd', 'company_number' => '11223344-X', 'address' => 'Mid Valley, Kuala Lumpur', 'phone' => '03-22018899', 'person_in_charge' => 'Ali bin Ahmad', 'photo' => null],
            ['name' => 'Johor Softworks Studio', 'company_number' => '99887766-V', 'address' => 'Skudai, Johor Bahru', 'phone' => '07-5543210', 'person_in_charge' => 'Tan Ah Kow', 'photo' => null],
            ['name' => 'Apex Cyber Security', 'company_number' => '55443322-T', 'address' => 'Cyberjaya, Selangor', 'phone' => '03-88991122', 'person_in_charge' => 'Suresh Kumar', 'photo' => null],
            ['name' => 'Shopee Mobile Malaysia', 'company_number' => '12345678-M', 'address' => 'Bangsar South, KL', 'phone' => '03-27771122', 'person_in_charge' => 'Lee Mei Ling', 'photo' => null],
            ['name' => 'KPMG IT Advisory', 'company_number' => '87654321-K', 'address' => 'Bandar Utama, Petaling Jaya', 'phone' => '03-77213344', 'person_in_charge' => 'David Beckham', 'photo' => null],
        ]);
    }
}