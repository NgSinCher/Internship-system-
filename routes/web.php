<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\TemplateController;
use App\Models\Information;
use App\Models\Template;
use App\Models\InternshipAllocation; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalUsers = \App\Models\User::count();
    $announcements = \Schema::hasTable('announcements') ? \App\Models\Announcement::latest()->get() : [];
    
    // 捞出资讯、准则、模板
    $infoList = \Schema::hasTable('information') ? Information::where('type', 'info')->latest()->get() : collect([]);
    $rulesList = \Schema::hasTable('information') ? Information::where('type', 'rule')->latest()->get() : collect([]);
    $templatesList = \Schema::hasTable('templates') ? Template::latest()->get() : collect([]);

    $myAllocation = null;
    if (auth()->user()->role === 'student' && \Schema::hasTable('internship_allocations')) {
        $myAllocation = InternshipAllocation::with(['company', 'lecturer'])
                        ->where('student_id', auth()->id())
                        ->first();
    }
    
    return view('dashboard', compact(
        'totalUsers', 
        'announcements', 
        'infoList', 
        'rulesList', 
        'templatesList',
        'myAllocation'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== 1. ADMIN 路由 ====================
    Route::get('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.user.create');
    Route::post('/admin/create-user', [AdminController::class, 'storeUser'])->name('admin.user.store');

    Route::get('/admin/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::get('/admin/create-company', [CompanyController::class, 'create'])->name('admin.companies.create');
    Route::post('/admin/store-company', [CompanyController::class, 'store'])->name('admin.companies.store');
    
    Route::get('/admin/companies/{id}/edit', [CompanyController::class, 'edit'])->name('admin.companies.edit');
    Route::put('/admin/companies/{id}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::delete('/admin/companies/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');

    Route::get('/admin/allocation', [AllocationController::class, 'index'])->name('admin.allocate.index');
    Route::post('/admin/allocation', [AllocationController::class, 'store'])->name('admin.allocate.store');
    
    Route::get('/admin/allocation/{id}/edit', [AllocationController::class, 'edit'])->name('admin.allocate.edit');
    Route::put('/admin/allocation/{id}', [AllocationController::class, 'update'])->name('admin.allocate.update');
    Route::delete('/admin/allocation/{id}', [AllocationController::class, 'destroy'])->name('admin.allocate.destroy');

    // ==================== 2. STUDENT 路由 ====================
    Route::get('/student/logbook', [LogBookController::class, 'index'])->name('student.logbook.index');
    Route::post('/student/logbook', [LogBookController::class, 'store'])->name('student.logbook.store');
    Route::post('/student/upload-report', [LogBookController::class, 'uploadReport'])->name('student.report.upload');

    // ==================== 3. LECTURER 路由 ====================
    Route::get('/lecturer/students', [LecturerController::class, 'index'])->name('lecturer.students.index');
    Route::post('/lecturer/grade/{id}', [LecturerController::class, 'grade'])->name('lecturer.grade.store');

    // ==================== 4. COMPANY SV (企业老板) 路由 ====================
    Route::get('/company/students', [App\Http\Controllers\CompanySVController::class, 'index'])->name('company.students');
    Route::post('/company/log/{id}/review', [App\Http\Controllers\CompanySVController::class, 'reviewLog'])->name('company.log.review');
    // 🌟🌟🌟 补上的大结局铁轨：老板提交100分评价表的接收通道 🌟🌟🌟
    Route::post('/company/allocation/{id}/evaluate', [App\Http\Controllers\CompanySVController::class, 'submitEvaluation'])->name('company.evaluate.store');

    // ==================== 5. 公告路由 (Announcement) ====================
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // ==================== 6. 信息路由 (Information) ====================
    Route::get('/admin/information', [InformationController::class, 'index'])->name('admin.info.index');
    Route::post('/admin/information', [InformationController::class, 'store'])->name('admin.info.store');
    Route::delete('/admin/information/{id}', [InformationController::class, 'destroy'])->name('admin.info.destroy');

    Route::post('/admin/templates', [TemplateController::class, 'store'])->name('admin.templates.store');
    Route::delete('/admin/templates/{id}', [TemplateController::class, 'destroy'])->name('admin.templates.destroy');
});

require __DIR__.'/auth.php';