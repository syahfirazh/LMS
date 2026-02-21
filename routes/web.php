<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\DosenAuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\MahasiswaProfileController;
use App\Http\Controllers\MahasiswaJoinKelasController;
use App\Http\Controllers\Mahasiswa\AttendanceController as MahasiswaAttendanceController;

// Controllers Dosen
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\CourseController;
use App\Http\Controllers\Dosen\KelasController;
use App\Http\Controllers\Dosen\CourseSessionController;
use App\Http\Controllers\Dosen\MateriController;
use App\Http\Controllers\Dosen\SessionController;
use App\Http\Controllers\Dosen\AttendanceController;
use App\Http\Controllers\Dosen\AssignmentController;
use App\Http\Controllers\Dosen\AssignmentGradeController;
use App\Http\Controllers\Dosen\RekapNilaiController;
use App\Http\Controllers\Dosen\ProfilDosenController;
use App\Http\Controllers\Dosen\DosenMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes - LMS Inklusi UMMI
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. AUTHENTICATION & PUBLIC
// ========================================================================

Route::get('/', function () {
    return view('choose_role');
})->name('choose_role');

Route::get('/setup-voice', function () {
    return view('setup_voice'); 
})->name('setup.voice');

// Login Mahasiswa
Route::get('/login', function () {
    return view('login'); 
})->name('login');
Route::post('/login-process', [AuthController::class, 'loginMahasiswa'])->name('login.post');
Route::post('/login/mahasiswa', [MahasiswaAuthController::class, 'login'])->name('login.mahasiswa.post');

// Login Dosen
Route::get('/login-dosen', function () {
    return view('dosen_login');
})->name('login.dosen');
Route::post('/login/dosen', [DosenAuthController::class, 'login'])->name('login.dosen.post');

// Logout Umum
Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout');


// ========================================================================
// 2. 🎓 AREA MAHASISWA (Student)
// ========================================================================

Route::middleware('auth:mahasiswa')->group(function () {
    
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/mahasiswa/profile', [MahasiswaProfileController::class, 'index'])
    ->middleware('auth:mahasiswa')->name('profile');
    Route::get('/pemberitahuan', function () { return view('notifications'); })->name('notifications');
    Route::get('/pesan', function () { return view('messages'); })->name('messages');
    Route::get('/bantuan', function () { return view('help'); })->name('help');
    Route::get('/mata-kuliah', [MahasiswaController::class, 'index'])
        ->name('courses.index');
    Route::get('/mata-kuliah/{kelas}', [MahasiswaController::class, 'show'])
    ->name('course.detail');

        Route::get('/presensi/{session}',
    [MahasiswaAttendanceController::class, 'index'])
    ->name('mahasiswa.presensi');

Route::post('/presensi/{session}/{status}', 
    [MahasiswaAttendanceController::class, 'store']
)->name('mahasiswa.presensi.store');
    
    // Join Kelas
    Route::get('/gabung-kelas', function () { return view('join_course'); })->name('courses.join');
    Route::post('/mahasiswa/join-kelas',[MahasiswaJoinKelasController::class, 'join'])->name('mahasiswa.join.kelas');
    Route::post('/mahasiswa/join', [MahasiswaController::class, 'joinByCode'])->name('mahasiswa.join.bycode');

    // Group: Detail Mata Kuliah (Prototype)
    Route::prefix('mata-kuliah/struktur-data')->group(function () {
        Route::get('/', function () { return view('course_detail'); })->name('course.prototype.detail');
        Route::get('/mata-kuliah', [MahasiswaController::class, 'index'])
    ->name('courses');
        Route::get('mata-kuliah/struktur-data/mata-kuliah/{kelas}/topik/array',[MahasiswaController::class, 'topic'])->name('topic.detail');
        Route::get('/penugasan', function () { return view('course_assignments'); })->name('course.assignments');
        Route::get('/penugasan/detail', function () { return view('assignment_detail'); })->name('assignment.detail');
        Route::get('/presensi/{session}',
    [\App\Http\Controllers\Mahasiswa\AttendanceController::class, 'attendance']
)->name('course.attendance');
        Route::get('/anggota', function () { return view('course_members'); })->name('course.members');
    });

    // Group: Ujian Online
    Route::prefix('ujian')->group(function () {
        Route::get('/', function () { return view('exams'); })->name('exams');
        Route::get('/gabung', function () { return view('join_exam'); })->name('join.exam');
        Route::get('/mulai', function () { return view('exam_start'); })->name('exam.start'); 
    });
});


// ... (Bagian atas file tetap sama)

// ========================================================================
// 3. 👨‍🏫 AREA DOSEN (Lecturer)
// ========================================================================

Route::prefix('dosen')->middleware('auth:dosen')->group(function () {

    // --- DASHBOARD & UMUM ---
    Route::get('/', [DashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dosen.notifications');
    Route::get('/jadwal', [DashboardController::class, 'schedule'])->name('dosen.schedule');
    
    // --- MANAJEMEN MATA KULIAH (COURSES) ---
    Route::get('/mata-kuliah', [CourseController::class, 'index'])->name('dosen.courses');
    Route::get('mata-kuliah/{id}', [CourseController::class, 'manage'])->name('dosen.course.manage');
    Route::put('course/{kelas}/deskripsi', [CourseController::class, 'updateDeskripsi'])->name('dosen.course.updateDeskripsi');
    Route::post('course/{kelas}/sampul', [CourseController::class, 'updateSampul'])->name('dosen.course.updateSampul');

    // Manajemen Mahasiswa dalam Kelas
    Route::get('mata-kuliah/{kelas}/students', [CourseController::class, 'students'])->name('dosen.course.students');
    Route::post('/kelas/{kelas}/add-student', [CourseController::class, 'addStudent'])->name('dosen.course.addStudent');
    Route::delete('kelas/{kelas}/remove-student/{mahasiswa}',[CourseController::class, 'removeStudent'])->name('dosen.course.removeStudent');

    // --- MANAJEMEN KELAS (CRUD) ---
    Route::get('/kelas', [KelasController::class, 'index'])->name('dosen.kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('dosen.kelas.store');
    
    // 🔥 TAMBAHAN ROUTE UPDATE (Agar tidak error method not supported)
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('dosen.kelas.update'); 
    
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('dosen.kelas.destroy');

    // --- SESI & MATERI (SESSIONS) ---
    Route::post('course/{kelas}/session', [CourseController::class, 'storeSession'])->name('dosen.course.session.store');
    Route::get('mata-kuliah/{kelas}/session/{session}', [CourseSessionController::class, 'detail'])->name('dosen.course.session.detail');
    Route::get('/session/{id}', [SessionController::class, 'show'])->name('session.show');
    Route::post('/session/{id}/diskusi', [\App\Http\Controllers\Dosen\CourseSessionController::class, 'storeDiskusi'])->name('session.diskusi.store');
    Route::post('/session/{id}/materi', [MateriController::class, 'store'])->name('dosen.materi.store');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('dosen.materi.destroy');
    Route::put('/session/{id}/update-instruksi', [MateriController::class, 'updateInstruksi'])->name('dosen.session.updateInstruksi');
    Route::delete('/course/{kelas}/session/{session}', [App\Http\Controllers\Dosen\CourseController::class, 'destroySession'])->name('dosen.course.session.destroy');
    Route::get('/topic/{mahasiswa}', 
    [DosenMessageController::class, 'index'])
    ->name('dosen.topic');

Route::post('/send-message', 
    [DosenMessageController::class, 'send'])
    ->name('dosen.send');

Route::get('/fetch/{mahasiswa}', 
    [DosenMessageController::class, 'fetch'])
    ->name('dosen.fetch');
    Route::get('/session/{session}/realtime', function ($sessionId) {

    $session = \App\Models\CourseSession::findOrFail($sessionId);

    return response()->json([
        'description' => $session->description,
        'materis' => $session->materis()->latest()->get(),
        'messages' => $session->messages()->latest()->take(20)->get(),
    ]);
});

    // --- ABSENSI (ATTENDANCE) ---
    Route::get('kelas/{kelas}/absensi', [AttendanceController::class, 'index'])->name('dosen.attendance.index');
    Route::get('/attendance/history/{session}', [AttendanceController::class, 'history'])->name('dosen.attendance.history');
    Route::get('attendance/{session}/manual', [AttendanceController::class, 'manual'])->name('dosen.attendance.manual');
    Route::post('attendance/{session}/manual', [AttendanceController::class, 'storeManual'])->name('dosen.attendance.manual.store');
    Route::post('/attendance/{session}/save', [AttendanceController::class, 'save'])->name('dosen.attendance.save');
    Route::delete('/attendance/{session}/reset', [AttendanceController::class, 'reset'])->name('dosen.attendance.reset');

    // --- PENUGASAN (ASSIGNMENTS) ---
    Route::get('mata-kuliah/{kelas}/penugasan', [AssignmentController::class, 'index'])->name('dosen.course.assignments');
    Route::get('mata-kuliah/{kelas}/penugasan/create', [AssignmentController::class, 'create'])->name('dosen.assignment.create');
    Route::post('mata-kuliah/{kelas}/penugasan', [AssignmentController::class, 'store'])->name('dosen.course.assignments.store');
    Route::get('mata-kuliah/{kelas}/penugasan/{assignment}/edit', [AssignmentController::class, 'edit'])->name('dosen.assignment.edit');
    Route::put('mata-kuliah/{kelas}/penugasan/{assignment}', [AssignmentController::class, 'update'])->name('dosen.assignment.update');
    Route::delete('kelas/{kelas}/assignment/{assignment}', [AssignmentController::class, 'destroy'])->name('dosen.assignment.destroy');
    Route::put('kelas/{kelas}/assignment/{assignment}/publish', [AssignmentController::class, 'publish'])->name('dosen.assignment.publish');

    // Penilaian Tugas (Grading)
    Route::get('mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}', [AssignmentGradeController::class, 'show'])->name('dosen.assignment.grade');
    Route::post('mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}', [AssignmentGradeController::class, 'store'])->name('dosen.assignment.grade.store');
    Route::post('submission/{submission}/message', [AssignmentGradeController::class, 'sendMessage'])->name('dosen.assignment.message');

    // --- REKAP NILAI (GRADES) ---
    Route::get('kelas/{kelas}/rekap-nilai', [RekapNilaiController::class, 'index'])->name('dosen.grades.recap');
    Route::get('/course/{kelas}/grades/settings', [RekapNilaiController::class, 'settings'])->name('dosen.grades.settings');
    Route::post('/course/{kelas}/grades/settings', [RekapNilaiController::class, 'updateSettings'])->name('dosen.grades.settings.update');

    // --- PESAN (MESSAGES) ---
    Route::get('/messages', [DosenMessageController::class, 'index'])->name('dosen.messages');
    Route::get('/messages/{mahasiswa}', [DosenMessageController::class, 'show'])->name('dosen.messages.show');
    Route::post('/messages/send', [DosenMessageController::class, 'send'])->name('dosen.messages.send');
    Route::get('/messages/fetch/{mahasiswa}', [DosenMessageController::class, 'fetch'])->name('dosen.messages.fetch');

    // --- PROFIL DOSEN ---
    Route::get('/profile', [ProfilDosenController::class, 'index'])->name('dosen.profile');
    Route::get('/profile/edit', [ProfilDosenController::class, 'edit'])->name('dosen.profile.edit');
    Route::put('/profile', [ProfilDosenController::class, 'update'])->name('dosen.profile.update');
    Route::put('/profile/password', [ProfilDosenController::class, 'updatePassword'])->name('dosen.profile.password');

    // --- FITUR LAIN (PROTOTYPE) ---
    Route::get('/penilaian', function () { return view('dosen_grading'); })->name('dosen.grading');
    Route::get('/ujian', function () { return view('dosen_exams'); })->name('dosen.exams');

    // Detail Kelas Tab (Prototype)
    Route::prefix('kelas/struktur-data')->group(function () {
        Route::get('/rekap-nilai/edit', function () { return view('dosen_course_grades_edit'); })->name('dosen.grades.edit');
    });

});
