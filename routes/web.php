<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ========================================================================
// IMPORT CONTROLLERS
// ========================================================================
// Auth
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\DosenAuthController;

// Mahasiswa
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\MahasiswaProfileController;
use App\Http\Controllers\MahasiswaJoinKelasController;
use App\Http\Controllers\Mahasiswa\AttendanceController as MahasiswaAttendanceController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\Mahasiswa\MahasiswaNotificationController;
use App\Http\Controllers\Mahasiswa\MahasiswaMessageController; 
use App\Http\Controllers\Mahasiswa\ExamController as MahasiswaExamController;

// Dosen
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
use App\Http\Controllers\Dosen\ExamController;
use App\Http\Controllers\Dosen\DosenNotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes - LMS Inklusi UMMI
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. PUBLIC & AUTHENTICATION
// ========================================================================
Route::get('/', function () { return view('choose_role'); })->name('choose_role');
Route::get('/setup-voice', function () { return view('setup_voice'); })->name('setup.voice');

// --- Login & Logout Mahasiswa (Umum) ---
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login-process', [AuthController::class, 'loginMahasiswa'])->name('login.post');
Route::post('/login/mahasiswa', [MahasiswaAuthController::class, 'login'])->name('login.mahasiswa.post');

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// --- Login & Logout Dosen ---
Route::get('/login-dosen', function () { return view('dosen_login'); })->name('login.dosen');
Route::post('/login/dosen', [DosenAuthController::class, 'login'])->name('login.dosen.post');

// RUTE LOGIN GOOGLE DOSEN
Route::get('/login/dosen/google', [DosenAuthController::class, 'redirectToGoogle'])->name('login.dosen.google');
Route::get('/login/dosen/google/callback', [DosenAuthController::class, 'handleGoogleCallback']);

Route::get('/logout-dosen', function () {
    Auth::guard('dosen')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login.dosen');
})->name('logout.dosen');


// ========================================================================
// 2. AREA MAHASISWA (Student)
// ========================================================================
Route::middleware('auth:mahasiswa')->group(function () {
    
    // --- Menu Utama ---
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/mahasiswa/profile', [MahasiswaProfileController::class, 'index'])->name('profile');
    Route::post('/mata-kuliah/{kelas}/assignment/{assignment}/message', [MahasiswaController::class, 'sendMessage'])->name('mahasiswa.assignment.message.store');
    Route::get('/mata-kuliah/{kelas}/penugasan', [\App\Http\Controllers\Mahasiswa\AssignmentController::class, 'index'])->name('course.assignments');
    
    Route::controller(MahasiswaController::class)->group(function () {
        Route::get('/mata-kuliah', 'index')->name('courses.index');
        Route::get('/mata-kuliah/{kelas}', 'show')->name('course.detail');
        Route::post('/mahasiswa/join', 'joinByCode')->name('mahasiswa.join.bycode');
        Route::get('/kelas/{kelas}/anggota/search', 'search')->name('course.members.search');
    });

    // --- Fitur Tambahan ---
    Route::get('/pemberitahuan', [MahasiswaNotificationController::class, 'index'])->name('notifications');
    Route::post('/pemberitahuan/read-all', [MahasiswaNotificationController::class, 'markAllRead'])->name('notifications.read');
    Route::get('/mata-kuliah/{kelas}/penugasan/{assignment}', [\App\Http\Controllers\Mahasiswa\AssignmentController::class, 'show'])->name('mahasiswa.assignment.detail');
    
    // --- Pesan Inklusi Mahasiswa ---
    Route::controller(MahasiswaMessageController::class)->group(function () {
        Route::get('/pesan', 'index')->name('messages');
        Route::get('/messages/search', 'search')->name('messages.search');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{dosen}', 'show')->name('messages.show');
    });

    Route::post('/discussion/{session}', [DiscussionController::class, 'store'])->name('discussion.store'); 
    Route::get('/bantuan', function () { return view('help'); })->name('help');
    Route::get('/student/chat/{conversation}/messages', [DiscussionController::class,'messages']);
    Route::post('/student/chat/{conversation}/send', [DiscussionController::class,'send']);

    // --- Presensi Mahasiswa ---
    Route::controller(MahasiswaAttendanceController::class)->group(function () {
        Route::get('/presensi/{session}', [AttendanceController::class, 'attendance'])->name('mahasiswa.presensi');
        Route::post('/presensi/{id}/{status}', 'store')->name('presensi.store');
    });
    
    // --- Bergabung Kelas ---
    Route::get('/gabung-kelas', function () { return view('join_course'); })->name('courses.join');
    Route::post('/mahasiswa/join-kelas', [MahasiswaJoinKelasController::class, 'join'])->name('mahasiswa.join.kelas');

    // --- Detail Mata Kuliah Spesifik ---
    Route::prefix('mata-kuliah/struktur-data')->group(function () {
        Route::get('/', function () { return view('course_detail'); })->name('course.prototype.detail');
        Route::get('mata-kuliah/{kelas}/topik/{session}', [MahasiswaController::class, 'topic'])->name('topic.detail');
        Route::post('mata-kuliah/{kelas}/assignment/{assignment}/submit', [MahasiswaController::class, 'submitAssignment'])->name('assignment.submit');
        Route::get('/presensi/{session}', [MahasiswaAttendanceController::class, 'attendance'])->name('course.attendance');
        Route::get('/mata-kuliah/{kelas}/anggota', [MahasiswaController::class, 'members'])->name('course.members');
    });

    // --- Fitur Ujian Online Mahasiswa ---
    Route::prefix('ujian')->controller(MahasiswaExamController::class)->group(function () {
        Route::get('/', 'index')->name('exams');
        Route::get('/gabung', 'join')->name('join.exam');
        Route::post('/verifikasi', 'verifyToken')->name('exam.verify');
        Route::get('/{id?}/persiapan', 'preparation')->name('exam.preparation');
        Route::post('/{id?}/mulai', 'start')->name('exam.start'); 
        Route::get('/{id?}/kerjakan', 'play')->name('exam.play');
        Route::post('/{id?}/submit', 'submit')->name('exam.submit');
    });
});


// ========================================================================
// 3. AREA DOSEN (Lecturer)
// ========================================================================
Route::prefix('dosen')->middleware('auth:dosen')->group(function () {

    // --- DASHBOARD & MENU UTAMA ---
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dosen.dashboard');
        Route::get('/pemberitahuan', [DosenNotificationController::class, 'index'])->name('dosen.notifications');
        Route::get('/pemberitahuan/{id}', [DosenNotificationController::class, 'read'])->name('dosen.notifications.read.single');
        Route::post('/pemberitahuan/read-all', [DosenNotificationController::class, 'markAllRead'])->name('dosen.notifications.read');
        Route::get('/jadwal', 'schedule')->name('dosen.schedule');
    });

    // --- MANAJEMEN UJIAN ---
    Route::controller(ExamController::class)->group(function () {
        Route::get('/ujian', 'index')->name('dosen.exams');
        Route::post('/ujian', 'store')->name('dosen.exams.store');
        Route::post('/ujian/{exam}/publish', 'publish')->name('dosen.exams.publish');
        Route::get('/ujian/{exam}/soal', 'questions')->name('dosen.exams.questions');
        Route::post('/ujian/{exam}/soal', 'storeQuestions')->name('dosen.exams.questions.store');
        
        // [ROUTE BARU UNTUK PANTAU DAN HASIL]
        Route::get('/ujian/{exam}/pantau', 'monitor')->name('dosen.exams.monitor');
        Route::get('/ujian/{exam}/hasil', 'results')->name('dosen.exams.results');
        
        Route::post('/ujian/{exam}/stop', 'stop')->name('dosen.exams.stop');
        Route::delete('/ujian/{exam}', 'destroy')->name('dosen.exams.destroy');
    });
    
    // --- PROFIL DOSEN ---
    Route::controller(ProfilDosenController::class)->group(function () {
        Route::get('/profile', 'index')->name('dosen.profile');
        Route::get('/profile/edit', 'edit')->name('dosen.profile.edit');
        Route::put('/profile', 'update')->name('dosen.profile.update');
        Route::put('/profile/password', 'updatePassword')->name('dosen.profile.password');
    });

    // --- MANAJEMEN KELAS (CRUD) ---
    Route::controller(KelasController::class)->group(function () {
        Route::get('/kelas', 'index')->name('dosen.kelas.index');
        Route::post('/kelas', 'store')->name('dosen.kelas.store');
        Route::put('/kelas/{id}', 'update')->name('dosen.kelas.update'); 
        Route::delete('/kelas/{id}', 'destroy')->name('dosen.kelas.destroy');
    });

    // --- MANAJEMEN MATA KULIAH & MAHASISWA ---
    Route::controller(CourseController::class)->group(function () {
        Route::get('/mata-kuliah', 'index')->name('dosen.courses');
        Route::get('/mata-kuliah/{id}', 'manage')->name('dosen.course.manage');
        Route::put('/course/{kelas}/deskripsi', 'updateDeskripsi')->name('dosen.course.updateDeskripsi');
        Route::post('/course/{kelas}/sampul', 'updateSampul')->name('dosen.course.updateSampul');
        Route::get('/mata-kuliah/{kelas}/students', 'students')->name('dosen.course.students');
        Route::post('/kelas/{kelas}/add-student', 'addStudent')->name('dosen.course.addStudent');
        Route::delete('/kelas/{kelas}/remove-student/{mahasiswa}', 'removeStudent')->name('dosen.course.removeStudent');
        Route::post('/course/{kelas}/session', 'storeSession')->name('dosen.course.session.store');
        Route::delete('/course/{kelas}/session/{session}', 'destroySession')->name('dosen.course.session.destroy');
    });

    // --- MANAJEMEN SESI & MATERI (MODUL) ---
    Route::controller(CourseSessionController::class)->group(function () {
        Route::get('/mata-kuliah/{kelas}/session/{session}', 'detail')->name('dosen.course.session.detail');
        Route::post('/session/{id}/diskusi', 'storeDiskusi')->name('session.diskusi.store');
        Route::post('/discussion/{session}', [DiscussionController::class, 'store'])->name('discussion.store');
    });

    Route::get('/session/{id}', [SessionController::class, 'show'])->name('session.show');
    
    Route::controller(MateriController::class)->group(function () {
        Route::put('/session/{id}/update-instruksi', 'updateInstruksi')->name('dosen.session.updateInstruksi');
        Route::post('/session/{id}/materi', 'store')->name('dosen.materi.store');
        Route::delete('/materi/{id}', 'destroy')->name('dosen.materi.destroy');
    });

    // API Realtime Sesi
    Route::get('/session/{session}/realtime', function ($sessionId) {
        $session = \App\Models\CourseSession::findOrFail($sessionId);
        return response()->json([
            'description' => $session->description,
            'materis'     => $session->materis()->latest()->get(),
            'messages'    => $session->messages()->latest()->take(20)->get(),
        ]);
    });

    // --- MANAJEMEN ABSENSI ---
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/kelas/{kelas}/absensi', 'index')->name('dosen.attendance.index');
        Route::get('/attendance/history/{session}', 'history')->name('dosen.attendance.history');
        Route::get('/attendance/{session}/manual', 'manual')->name('dosen.attendance.manual');
        Route::post('/attendance/{session}/manual', 'storeManual')->name('dosen.attendance.storeManual');
        Route::post('/attendance/{session}/save', 'save')->name('dosen.attendance.save');
        Route::delete('/attendance/{session}/reset', 'reset')->name('dosen.attendance.reset');
    });

    // --- MANAJEMEN PENUGASAN (TUGAS & KUIS) ---
    Route::controller(AssignmentController::class)->group(function () {
        Route::get('/mata-kuliah/{kelas}/penugasan', 'index')->name('dosen.course.assignments');
        Route::get('/mata-kuliah/{kelas}/penugasan/create', 'create')->name('dosen.assignment.create');
        Route::post('/mata-kuliah/{kelas}/penugasan', 'store')->name('dosen.course.assignments.store');
        Route::get('/mata-kuliah/{kelas}/penugasan/{assignment}/edit', 'edit')->name('dosen.assignment.edit');
        Route::put('/mata-kuliah/{kelas}/penugasan/{assignment}', 'update')->name('dosen.assignment.update');
        Route::delete('/kelas/{kelas}/assignment/{assignment}', 'destroy')->name('dosen.assignment.destroy');
        Route::put('/kelas/{kelas}/assignment/{assignment}/publish', 'publish')->name('dosen.assignment.publish');
        Route::get('/kelas/{kelas}/assignment-recap', 'recap')->name('dosen.assignment.recap');
    });
    
    // --- PENILAIAN TUGAS SATUAN & DISKUSI ---
    Route::controller(AssignmentGradeController::class)->group(function () {
        Route::get('/mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}', 'show')->name('dosen.assignment.grade');
        Route::post('/mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}', 'store')->name('dosen.assignment.grade.store');
        Route::post('/assignment/{assignment}/message/{mahasiswa}', 'storeMessage')->name('dosen.assignment.message.store');
        Route::post('/submission/{submission}/message', 'sendMessage')->name('dosen.assignment.message');
    });

    // --- MANAJEMEN PENILAIAN AKHIR (GRADES) ---
    Route::controller(RekapNilaiController::class)->group(function () {
        Route::get('/penilaian', 'globalInput')->name('dosen.grading');
        Route::post('/penilaian/{kelas}', 'globalStore')->name('dosen.grading.store');
        Route::get('/kelas/{kelas}/rekap-nilai', 'index')->name('dosen.grades.recap');
        Route::put('/kelas/{kelas}/rekap-nilai/edit/{mahasiswa}', 'update')->name('dosen.grades.update');
        Route::post('/kelas/{kelas}/grades/settings', 'updateSettings')->name('dosen.grades.settings.update');
        Route::post('/kelas/{kelas}/input-nilai/import', 'importExcel')->name('dosen.grades.import');
    });

    // --- PESAN / CHAT REAL-TIME (MESSAGES) ---
    Route::controller(DosenMessageController::class)->group(function () {
        Route::get('/messages', 'index')->name('dosen.messages');
        Route::get('/messages-search', 'searchStudents')->name('dosen.messages.search');
        Route::get('/messages/{mahasiswa}', 'show')->name('dosen.messages.show');
        Route::post('/messages/send', 'send')->name('dosen.messages.send');
        Route::get('/messages/fetch/{mahasiswa}', 'fetch')->name('dosen.messages.fetch');
    });

});