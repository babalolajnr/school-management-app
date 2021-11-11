<?php

use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\ADController;
use App\Http\Controllers\ADTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeactivatedController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\HosRemarkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDController;
use App\Http\Controllers\PDTypeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherRemarkController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
})->middleware('guest:teacher,web');

Route::get('guardian/performance-report/{student:admission_no}/{periodSlug}', [ResultController::class, 'showPerformanceReport'])->middleware('valid.signature')->name('result.guardian.show.performance')->where('student', '.*');

Route::get('/deactivated', [DeactivatedController::class, 'index'])->middleware(['auth:teacher,web'])->name('deactivated');

// Accessible to every logged in entity
Route::middleware(['auth:teacher,web', 'verified:teacher,web', 'activeAndVerified'])->group(function () {

    Route::get('notifications/read/{notification}', [NotificationController::class, 'read'])->name('notification.read');
    Route::get('notifications/inbox', [NotificationController::class, 'inbox'])->name('notification.inbox');

    Route::get('teachers/edit/{teacher:slug}', [TeacherController::class, 'edit'])->name('teacher.edit');

    Route::get('/classrooms/view/{classroom:slug}', [ClassroomController::class, 'show'])->name('classroom.show')->middleware('classTeacherOrUser');

    Route::get('/classrooms/show/{classroom:slug}/{branch:name}', [ClassroomController::class, 'showBranch'])->name('classroom.show.branch');

    Route::get('teachers/view/{teacher:slug}', [TeacherController::class, 'show'])->name('teacher.show');

    Route::prefix('teachers')->name('teacher.')->middleware('auth:teacher')->group(function () {

        //Teacher routes
        Route::patch('update/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::patch('/store-signature/{teacher:slug}', [TeacherController::class, 'storeSignature'])->name('store.signature');
        Route::patch('/update-password/{teacher}', [TeacherController::class, 'updatePassword'])->name('update.password');
    });

    Route::prefix('results')->name('result.')->group(function () {

        //Result ROutes
        Route::get('/edit/{result}', [ResultController::class, 'edit'])->name('edit');
        Route::patch('/update/{result}', [ResultController::class, 'update'])->name('update');
        Route::delete('/delete/{result}', [ResultController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('teacher-remarks')->name('remark.teacher.')->middleware('studentClassTeacher')->group(function () {

        //Only Student's current classroom teacher can access this routes
        Route::get('/create/{student:admission_no}', [TeacherRemarkController::class, 'create'])->name('create')->where('student', '.*');
        Route::post('/store/{student}', [TeacherRemarkController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::middleware('studentClassTeacherOrUser')->group(function () {
        //Routes accessible to student's classteachers and master-user and admins only

        Route::prefix('students')->name('student.')->group(function () {

            // student routes
            Route::get('/results/term/{student:admission_no}/{termSlug}/{academicSessionName}', [StudentController::class, 'getTermResults'])->name('get.term.results')->where('academicSessionName', '.*')->where('student', '.*');
            Route::get('/view/{student:admission_no}', [StudentController::class, 'show'])->name('show')->where('student', '.*');
            Route::get('/results/sessional/{student:admission_no}/{academicSessionName}', [StudentController::class, 'getSessionalResults'])->name('get.sessional.results')->where('academicSessionName', '.*')->where('student', '.*');
            Route::get('/student-settings/{student:admission_no}', [StudentController::class, 'showStudentSettingsView'])->name('show.student.settingsView')->where('student', '.*');
        });

        Route::prefix('results')->name('result.')->group(function () {
            //Results Routes
            Route::get('/create/{student:admission_no}', [ResultController::class, 'create'])->name('create')->where('student', '.*');
            Route::get('/performance-report/{student:admission_no}/{periodSlug}', [ResultController::class, 'showPerformanceReport'])->name('show.performance')->where('student', '.*');
            Route::get('mail/performance-report/{student:admission_no}/{periodSlug}', [ResultController::class, 'mailStudentPerformanceReport'])->name('mail.performance')->where('student', '.*');
            Route::post('/store/{student}', [ResultController::class, 'store'])->name('store');
        });

        Route::prefix('attendance')->name('attendance.')->group(function () {
            //Attendance Domain Routes
            Route::get('/create/{student:admission_no}', [AttendanceController::class, 'create'])->name('create')->where('student', '.*');
            Route::post('/store/{student}/{periodSlug?}', [AttendanceController::class, 'storeOrUpdate'])->name('store');
        });

        Route::prefix('pds')->name('pd.')->group(function () {
            //Pychomotor Domain Routes
            Route::get('/create/{student:admission_no}', [PDController::class, 'create'])->name('create')->where('student', '.*');
            Route::post('/store/{student}/{periodSlug?}', [PDController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });

        Route::prefix('ads')->name('ad.')->group(function () {
            //Affective Domain Routes
            Route::get('/create/{student:admission_no}', [ADController::class, 'create'])->name('create')->where('student', '.*');
            Route::post('/store/{student}/{periodSlug?}', [ADController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
    });

    //Routes accessible to both master-users and admins only
    Route::middleware(['auth:web'])->group(function () {

        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::prefix('notifications')->name('notification.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/store', [NotificationController::class, 'store'])->name('store');
        });

        Route::prefix('branches')->name('branch.')->group(function () {
            Route::get('/', [BranchController::class, 'index'])->name('index');
            Route::get('/edit/{branch}', [BranchController::class, 'edit'])->name('edit');
            Route::post('/store', [BranchController::class, 'store'])->name('store');
            Route::patch('/update/{branch}', [BranchController::class, 'update'])->name('update');
            Route::patch('/assign-teachers/{branchClassroom}', [BranchController::class, 'assignTeachers'])->name('assign.teachers');
            Route::delete('/delete/{branch}', [BranchController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user:email}', [UserController::class, 'show'])->name('show');
            Route::patch('/update/{user}', [UserController::class, 'update'])->name('update');
            Route::patch('/store-signature/{user}', [UserController::class, 'storeSignature'])->name('store.signature');
            Route::patch('/update-password/{user}', [UserController::class, 'updatePassword'])->name('update.password');
            Route::patch('/verify/{user:email}', [UserController::class, 'verify'])->name('verify');
            Route::patch('/set-hos/{user}', [UserController::class, 'setHos'])->name('set-hos');
            Route::patch('/toggle-status/{user:email}', [UserController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/delete/{user:email}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('teachers')->name('teacher.')->group(function () {
            //Teacher routes
            Route::get('/', [TeacherController::class, 'index'])->name('index');
            Route::get('/create', [TeacherController::class, 'create'])->name('create');
            Route::get('/trashed', [TeacherController::class, 'showTrashed'])->name('show.trashed');
            Route::patch('user/update/{teacher}', [TeacherController::class, 'userTeacherUpdate'])->name('user.update');
            Route::post('/store', [TeacherController::class, 'store'])->name('store');
            Route::patch('/activate/{teacher}', [TeacherController::class, 'activate'])->name('activate');
            Route::patch('/restore/{id}', [TeacherController::class, 'restore'])->name('restore');
            Route::patch('/deactivate/{teacher}', [TeacherController::class, 'deactivate'])->name('deactivate');
            Route::delete('/delete/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
            Route::delete('/force-delete/{id}', [TeacherController::class, 'forceDelete'])->name('force.delete');
        });

        Route::prefix('hos-remarks')->name('remark.hos.')->group(function () {

            //HOS remark routes
            Route::get('/create/{student:admission_no}', [HosRemarkController::class, 'create'])->name('create')->where('student', '.*');
            Route::post('/store/{student}', [HosRemarkController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });

        Route::prefix('students')->name('student.')->group(function () {
            //Student Routes
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::get('/edit/{student:admission_no}', [StudentController::class, 'edit'])->name('edit')->where('student', '.*');
            Route::get('/trashed', [StudentController::class, 'showTrashed'])->name('show.trashed');
            Route::get('/alumni', [StudentController::class, 'getAlumni'])->name('get.alumni');
            Route::get('/inactive', [StudentController::class, 'getInactiveStudents'])->name('get.inactive');
            Route::post('/store/image/{student}', [StudentController::class, 'uploadImage'])->name('upload.image');
            Route::post('/store', [StudentController::class, 'store'])->name('store');
            Route::patch('/update/{student}', [StudentController::class, 'update'])->name('update');
            Route::patch('/activate/{student}', [StudentController::class, 'activate'])->name('activate');
            Route::patch('/deactivate/{student}', [StudentController::class, 'deactivate'])->name('deactivate');
            Route::patch('/promote/{student}', [StudentController::class, 'promote'])->name('promote');
            Route::patch('/demote/{student}', [StudentController::class, 'demote'])->name('demote');
            Route::patch('/graduate/{student}', [StudentController::class, 'graduate'])->name('graduate');
            Route::patch('/set-classroom-branch/{student}/{branch}', [StudentController::class, 'setClassroomBranch'])->name('set.classroom.branch');
            Route::patch('/restore/{id}', [StudentController::class, 'restore'])->name('restore');
            Route::delete('/delete/{student}', [StudentController::class, 'destroy'])->name('destroy');
            Route::delete('/force-delete/{id}', [StudentController::class, 'forceDelete'])->name('force.delete');
        });

        Route::prefix('classrooms')->name('classroom.')->group(function () {
            //Classroom Routes
            Route::get('/', [ClassroomController::class, 'index'])->name('index');
            Route::get('/edit/{classroom:slug}', [ClassroomController::class, 'edit'])->name('edit');
            Route::get('/set-subjects/{classroom:slug}', [ClassroomController::class, 'setSubjects'])->name('set.subjects');
            Route::get('/promote-or-demote-students/{classroom:slug}', [ClassroomController::class, 'promoteOrDemoteStudents'])->name('promote.or.demote.students');
            Route::post('/update-subjects/{classroom:slug}', [ClassroomController::class, 'updateSubjects'])->name('update.subjects');
            Route::post('/promote-students/{classroom:slug}', [ClassroomController::class, 'promoteStudents'])->name('promote.students');
            Route::post('/demote-students/{classroom:slug}', [ClassroomController::class, 'demoteStudents'])->name('demote.students');
            Route::post('/store', [ClassroomController::class, 'store'])->name('store');
            Route::patch('/assign-teacher/{classroom:slug}/{teacherSlug}', [ClassroomController::class, 'assignTeacher'])->name('assign.teacher');
            Route::patch('/update/{classroom:slug}', [ClassroomController::class, 'update'])->name('update');
            Route::patch('/update-branches/{classroom:slug}', [ClassroomController::class, 'updateBranches'])->name('update.branches');
            Route::delete('/delete/{classroom:slug}', [ClassroomController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('terms')->name('term.')->group(function () {
            //Term routes
            Route::get('/', [TermController::class, 'index'])->name('index');
            Route::get('/edit/{term:slug}', [TermController::class, 'edit'])->name('edit');
            Route::post('/store', [TermController::class, 'store'])->name('store');
            Route::patch('/update/{term:slug}', [TermController::class, 'update'])->name('update');
            Route::delete('/delete/{term:slug}', [TermController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('subjects')->name('subject.')->group(function () {
            // Subject routes
            Route::get('/', [SubjectController::class, 'index'])->name('index');
            Route::get('/edit/{subject:slug}', [SubjectController::class, 'edit'])->name('edit');
            Route::post('/store', [SubjectController::class, 'store'])->name('store');
            Route::patch('/update/{subject:slug}', [SubjectController::class, 'update'])->name('update');
            Route::delete('/delete/{subject:slug}', [SubjectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('academic-sessions')->name('academic-session.')->group(function () {
            //AcademicSession routes
            Route::get('/', [AcademicSessionController::class, 'index'])->name('index');
            Route::get('/edit/{academicSession:name}', [AcademicSessionController::class, 'edit'])->name('edit');
            Route::post('/store', [AcademicSessionController::class, 'store'])->name('store');
            Route::patch('/update/{academicSession:name}', [AcademicSessionController::class, 'update'])->name('update');
            Route::delete('/delete/{academicSession:name}', [AcademicSessionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('guardians')->name('guardian.')->group(function () {
            //Guardian Routes
            Route::get('/edit/{guardian:phone}', [GuardianController::class, 'edit'])->name('edit');
            Route::patch('/update/{guardian:phone}', [GuardianController::class, 'update'])->name('update');
        });

        Route::prefix('pd-types')->name('pd-type.')->group(function () {
            //Pychomotor domain type routes
            Route::get('/', [PDTypeController::class, 'index'])->name('index');
            Route::get('/edit/{pdType:slug}', [PDTypeController::class, 'edit'])->name('edit');
            Route::post('/store', [PDTypeController::class, 'store'])->name('store');
            Route::patch('/update/{pdType}', [PDTypeController::class, 'update'])->name('update');
            Route::delete('/delete/{pdType}', [PDTypeController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('ad-types')->name('ad-type.')->group(function () {
            //Affective domain type routes
            Route::get('/', [ADTypeController::class, 'index'])->name('index');
            Route::get('/edit/{adType:slug}', [ADTypeController::class, 'edit'])->name('edit');
            Route::post('/store', [ADTypeController::class, 'store'])->name('store');
            Route::patch('/update/{adType}', [ADTypeController::class, 'update'])->name('update');
            Route::delete('/delete/{adType}', [ADTypeController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('period')->name('period.')->group(function () {
            Route::get('/', [PeriodController::class, 'index'])->name('index');
            Route::get('/edit/{period:slug}', [PeriodController::class, 'edit'])->name('edit');
            Route::post('/store', [PeriodController::class, 'store'])->name('store');
            Route::patch('/update/{period:slug}', [PeriodController::class, 'update'])->name('update');
            Route::patch('/set-active/{period:slug}', [PeriodController::class, 'setActivePeriod'])->name('set-active-period');
            Route::delete('/delete/{period:slug}', [PeriodController::class, 'destroy'])->name('delete');
        });

        Route::prefix('fee')->name('fee.')->group(function () {
            Route::get('/', [FeeController::class, 'index'])->name('index');
            Route::post('/store', [FeeController::class, 'store'])->name('store');
            Route::get('/edit/{fee}', [FeeController::class, 'edit'])->name('edit');
            Route::patch('/update/{fee}', [FeeController::class, 'update'])->name('update');
            Route::delete('/delete/{fee}', [FeeController::class, 'destroy'])->name('destroy');
        });

        Route::get('email-class-performace-report/{classroom}', [ResultController::class, 'sendClassroomPerformanceReportEmail'])->name('email.class.performace.report');
    });
});

require __DIR__ . '/auth.php';
