<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\DosenAuthController;
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\CourseController;
use App\Http\Controllers\Dosen\KelasController;
use App\Http\Controllers\Dosen\CourseSessionController;
use App\Http\Controllers\Dosen\MateriController;
use App\Http\Controllers\Dosen\SessionController;
use App\Http\Controllers\Dosen\AttendanceController;
use App\Http\Controllers\Dosen\AssignmentController;
use App\Models\Kelas;
use App\Models\Assignment;
use App\Http\Controllers\Dosen\AssignmentGradeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Dosen\RekapNilaiController;
use App\Http\Controllers\Dosen\ProfilDosenController;
use App\Http\Controllers\Dosen\DosenMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes - LMS Inklusi UMMI
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. AUTHENTICATION (Login & Public)
// ========================================================================
Route::get('/', function () {
    return view('choose_role');
})->name('choose_role');

Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::get('/login-dosen', function () {
    return view('login_dosen');
})->name('login.dosen');


Route::post('/login-process', [AuthController::class, 'loginMahasiswa'])
    ->name('login.post');


Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout');



// ========================================================================
// 2. 🎓 AREA MAHASISWA (Student)
// ========================================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware('auth:mahasiswa')
->name('dashboard');


Route::get('/profil', function () { 
    return view('profile'); 
})->name('profile');

Route::get('/pemberitahuan', function () { 
    return view('notifications'); 
})->name('notifications');

Route::get('/pesan', function () { 
    return view('messages'); 
})->name('messages');

Route::get('/bantuan', function () { 
    return view('help'); 
})->name('help');

Route::get('/mata-kuliah', function () { 
    return view('courses'); 
})->name('courses');

Route::post('/login/mahasiswa', [MahasiswaAuthController::class, 'login'])
    ->name('login.mahasiswa.post');


// Route::post('/login-process', [AuthController::class, 'loginMahasiswa'])
//     ->name('login.post');





// Contoh Route (sesuaikan dengan controller kamu)
Route::get('/gabung-kelas', function () {
    return view('join_course');
})->name('courses.join');


// --- Group: Detail Mata Kuliah Mahasiswa ---
Route::prefix('mata-kuliah/struktur-data')->group(function () {
    
    Route::get('/', function () { 
        return view('course_detail'); 
    })->name('course.detail');

    Route::get('/topik/array', function () { 
        return view('topic_detail'); 
    })->name('topic.detail');

    Route::get('/penugasan', function () { 
        return view('course_assignments'); 
    })->name('course.assignments');

    Route::get('/penugasan/detail', function () { 
        return view('assignment_detail'); 
    })->name('assignment.detail');

    Route::get('/presensi', function () { 
        return view('course_attendance'); 
    })->name('course.attendance');

    Route::get('/anggota', function () { 
        return view('course_members'); 
    })->name('course.members');
});


// --- Group: Ujian Online Mahasiswa ---
Route::prefix('ujian')->group(function () {
    Route::get('/', function () { 
        return view('exams'); 
    })->name('exams');

    Route::get('/gabung', function () { 
        return view('join_exam'); 
    })->name('join.exam');

    Route::get('/mulai', function () { 
        return view('exam_start'); 
    })->name('exam.start'); 
});


/// ========================================================================
// 3. 👨‍🏫 AREA DOSEN (Lecturer)
// ========================================================================

Route::post('/login/dosen', [DosenAuthController::class, 'login'])
    ->name('login.dosen.post');

Route::prefix('dosen')
    ->middleware('auth:dosen')
    ->group(function () {

    // =========================
    // DASHBOARD & UMUM
    // =========================
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dosen.dashboard');

    Route::get('/mata-kuliah', [CourseController::class, 'index'])
        ->name('dosen.courses');

    Route::get('/jadwal', [DashboardController::class, 'schedule'])
        ->name('dosen.schedule');

    Route::get('/penilaian', function () {
        return view('dosen_grading'); 
    })->name('dosen.grading');

    Route::get('/ujian', function () {
        return view('dosen_exams'); 
    })->name('dosen.exams');

     Route::get('/messages', [DosenMessageController::class, 'index'])
            ->name('dosen.messages');

        Route::get('/messages/{mahasiswa}', [DosenMessageController::class, 'show'])
            ->name('dosen.messages.show');

        Route::post('/messages/send', [DosenMessageController::class, 'send'])
            ->name('dosen.messages.send');

            Route::get('/dosen/messages/fetch/{mahasiswa}', 
    [DosenMessageController::class, 'fetch']
)->name('dosen.messages.fetch');


     Route::get('/profile', [ProfilDosenController::class, 'index'])
        ->name('dosen.profile');

    Route::get('/profile/edit', [ProfilDosenController::class, 'edit'])
        ->name('dosen.profile.edit');

    Route::put('/profile', [ProfilDosenController::class, 'update'])
        ->name('dosen.profile.update');

    Route::put('/profile/password', [ProfilDosenController::class, 'updatePassword'])
        ->name('dosen.profile.password');

    Route::post(
    'course/{kelas}/session',
    [CourseController::class, 'storeSession']
    )->name('dosen.course.session.store');

    Route::get('/session/{id}', [SessionController::class, 'show'])->name('session.show');

Route::post('/session/{id}/diskusi', 
    [SessionController::class, 'storeDiskusi']
)->name('session.diskusi.store');

Route::get('/kelas', [KelasController::class, 'index'])
    ->name('dosen.kelas.index');



    // =========================
    // KELAS (CREATE / DELETE)
    // =========================
    Route::post('/kelas', [KelasController::class, 'store'])
        ->name('dosen.kelas.store');

    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])
        ->name('dosen.kelas.destroy');


    // =========================
    // 🔥 COURSE ACTION (HARUS DI ATAS)
    // =========================
    Route::put(
        'course/{kelas}/deskripsi',
        [CourseController::class, 'updateDeskripsi']
    )->name('dosen.course.updateDeskripsi');
    

    Route::post(
        'course/{kelas}/sampul',
        [CourseController::class, 'updateSampul']
    )->name('dosen.course.updateSampul');

    

// Pastikan rutenya ada di dalam group dosen (jika ada)
Route::put('/session/{id}/update-instruksi', [MateriController::class, 'updateInstruksi'])
    ->name('dosen.session.updateInstruksi');

     Route::post('/session/{id}/materi',
        [MateriController::class, 'store']
    )->name('dosen.materi.store');

    Route::delete('/materi/{id}',
        [MateriController::class, 'destroy']
    )->name('dosen.materi.destroy');

    

    



//     Route::post('/diskusi', 
//     [SessionController::class, 'store']
// )->name('diskusi.store')->middleware('auth');


    // =========================
    // ⚠️ COURSE MANAGE (PALING UMUM → DI BAWAH)
    // =========================
    


    Route::get(
    'mata-kuliah/{kelas}/session/{session}',
    [CourseSessionController::class, 'detail']
)->name('dosen.course.session.detail');

// Route::get('/absensi', function () {
//     $kelas = \App\Models\Kelas::where('dosen_id', auth('dosen')->id())
//                 ->latest()
//                 ->firstOrFail();

//     return redirect()->route('dosen.attendance.index', $kelas);
// })->name('dosen.course.attendance');


        Route::get('kelas/{kelas}/absensi',
    [AttendanceController::class, 'index']
)->name('dosen.attendance.index');

Route::get('/dosen/attendance/history/{session}', [AttendanceController::class, 'history'])
->name('dosen.attendance.history');

Route::get('attendance/{session}/manual',
    [AttendanceController::class, 'manual']
)->name('dosen.attendance.manual');

Route::post('attendance/{session}/manual',
    [AttendanceController::class, 'storeManual']
)->name('dosen.attendance.manual.store');

Route::post('/dosen/attendance/{session}/save',
    [AttendanceController::class, 'save']
)->name('dosen.attendance.save');

Route::delete('/dosen/attendance/{session}/reset',
    [AttendanceController::class, 'reset']
)->name('dosen.attendance.reset');

Route::get(
    'mata-kuliah/{kelas}/penugasan',
    [AssignmentController::class, 'index']
)->name('dosen.course.assignments');

// Route::get('/penugasan', function () {

//     $kelas = Kelas::where('dosen_id', auth('dosen')->id())
//                 ->latest()
//                 ->firstOrFail();

//     return redirect()->route(
//         'dosen.course.assignments',
//         ['kelas' => $kelas->id]
//     );

// })->name('dosen.penugasan');

Route::get(
    'mata-kuliah/{kelas}/penugasan/create',
    [AssignmentController::class, 'create']
)->name('dosen.assignment.create');

Route::post(
    'mata-kuliah/{kelas}/penugasan',
    [AssignmentController::class, 'store']
)->name('dosen.course.assignments.store');

 Route::get(
    'mata-kuliah/{kelas}/penugasan/{assignment}/edit',
    [AssignmentController::class, 'edit']
)->name('dosen.assignment.edit');

Route::put(
        'mata-kuliah/{kelas}/penugasan/{assignment}',
        [AssignmentController::class, 'update']
    )->name('dosen.assignment.update');

     Route::put(
    'kelas/{kelas}/assignment/{assignment}/publish',
    [AssignmentController::class, 'publish']
)->name('dosen.assignment.publish');


    Route::delete(
    'kelas/{kelas}/assignment/{assignment}',
    [AssignmentController::class, 'destroy']
)->name('dosen.assignment.destroy');


Route::get(
    'mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}',
    [AssignmentGradeController::class, 'show']
)->name('dosen.assignment.grade');

Route::post(
    'mata-kuliah/{kelas}/assignment/{assignment}/grade/{mahasiswa?}',
    [AssignmentGradeController::class, 'store']
)->name('dosen.assignment.grade.store');

Route::post(
    'submission/{submission}/message',
    [AssignmentGradeController::class, 'sendMessage']
)->name('dosen.assignment.message');

Route::post('/mahasiswa/join-kelas', [MahasiswaController::class, 'joinKelas'])
->name('mahasiswa.join.kelas');

Route::post('/mahasiswa/join', 
    [MahasiswaController::class, 'joinByCode'])
    ->name('mahasiswa.join.bycode');


Route::post('/dosen/kelas/{kelas}/add-student', 
    [CourseController::class, 'addStudent'])
    ->name('dosen.course.addStudent');



Route::get(
    'mata-kuliah/{kelas}/students',
    [CourseController::class, 'students']
)->name('dosen.course.students');




    Route::get(
    'kelas/{kelas}/rekap-nilai',
    [RekapNilaiController::class, 'index']
)->name('dosen.grades.recap');


Route::get(
    '/dosen/course/{kelas}/grades/settings',
    [RekapNilaiController::class, 'settings']
)->name('dosen.grades.settings');

Route::post(
    '/dosen/course/{kelas}/grades/settings',
    [RekapNilaiController::class, 'updateSettings']
)->name('dosen.grades.settings.update');


Route::get(
        'mata-kuliah/{kelas}',
        [CourseController::class, 'manage']
    )->name('dosen.course.manage');






    // =========================
    // DETAIL KELAS (TAB)
    // =========================
    Route::prefix('kelas/struktur-data')->group(function () {


        

        Route::get('/rekap-nilai/edit', function () {
            return view('dosen_course_grades_edit'); 
        })->name('dosen.grades.edit');

       
    });
});

