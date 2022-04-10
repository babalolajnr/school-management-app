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
use App\Http\Livewire\AcademicSession\Index as AcademicSessionIndex;
use App\Http\Livewire\Notification\CreateNotification;
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
            Route::get('/', CreateNotification::class)->name('index');
        });

        Route::controller(BranchController::class)->prefix('branches')->name('branch.')->group(function () {
            Route::get('/',  'index')->name('index');
            Route::get('/edit/{branch}',  'edit')->name('edit');
            Route::get('/assign-main-teacher/{branchClassroom}/{teacher}',  'assignMainTeacher')->name('assign.main.teacher');
            Route::post('/store',  'store')->name('store');
            Route::patch('/update/{branch}',  'update')->name('update');
            Route::patch('/assign-teachers/{branchClassroom}',  'assignTeachers')->name('assign.teachers');
            Route::delete('/delete/{branch}',  'destroy')->name('destroy');
        });

        Route::controller(UserController::class)->prefix('users')->name('user.')->group(function () {
            Route::get('/',  'index')->name('index');
            Route::get('/{user:email}',  'show')->name('show');
            Route::patch('/update/{user}',  'update')->name('update');
            Route::patch('/store-signature/{user}',  'storeSignature')->name('store.signature');
            Route::patch('/update-password/{user}',  'updatePassword')->name('update.password');
            Route::patch('/verify/{user:email}',  'verify')->name('verify');
            Route::patch('/set-hos/{user}',  'setHos')->name('set-hos');
            Route::patch('/toggle-status/{user:email}',  'toggleStatus')->name('toggle-status');
            Route::delete('/delete/{user:email}',  'destroy')->name('destroy');
        });

        Route::controller(TeacherController::class)->prefix('teachers')->name('teacher.')->group(function () {
            //Teacher routes
            Route::get('/',  'index')->name('index');
            Route::get('/create',  'create')->name('create');
            Route::get('/trashed',  'showTrashed')->name('show.trashed');
            Route::patch('user/update/{teacher}',  'userTeacherUpdate')->name('user.update');
            Route::post('/store',  'store')->name('store');
            Route::patch('/activate/{teacher}',  'activate')->name('activate');
            Route::patch('/restore/{id}',  'restore')->name('restore');
            Route::patch('/deactivate/{teacher}',  'deactivate')->name('deactivate');
            Route::delete('/delete/{teacher}',  'destroy')->name('destroy');
            Route::delete('/force-delete/{id}',  'forceDelete')->name('force.delete');
        });

        Route::controller(StudentController::class)->prefix('students')->name('student.')->group(function () {
            //Student Routes
            Route::get('/',  'index')->name('index');
            Route::get('/create',  'create')->name('create');
            Route::get('/edit/{student:admission_no}',  'edit')->name('edit')->where('student', '.*');
            Route::get('/trashed',  'showTrashed')->name('show.trashed');
            Route::get('/alumni',  'getAlumni')->name('get.alumni');
            Route::get('/inactive',  'getInactiveStudents')->name('get.inactive');
            Route::post('/store/image/{student}',  'uploadImage')->name('upload.image');
            Route::post('/store',  'store')->name('store');
            Route::patch('/update/{student}',  'update')->name('update');
            Route::patch('/activate/{student}',  'activate')->name('activate');
            Route::patch('/deactivate/{student}',  'deactivate')->name('deactivate');
            Route::patch('/promote/{student}',  'promote')->name('promote');
            Route::patch('/demote/{student}',  'demote')->name('demote');
            Route::patch('/graduate/{student}',  'graduate')->name('graduate');
            Route::patch('/set-classroom-branch/{student}/{branch}',  'setClassroomBranch')->name('set.classroom.branch');
            Route::patch('/restore/{id}',  'restore')->name('restore');
            Route::delete('/delete/{student}',  'destroy')->name('destroy');
            Route::delete('/force-delete/{id}',  'forceDelete')->name('force.delete');
        });

        Route::controller(ClassroomController::class)->prefix('classrooms')->name('classroom.')->group(function () {
            //Classroom Routes
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{classroom:slug}', 'edit')->name('edit');
            Route::get('/set-subjects/{classroom:slug}', 'setSubjects')->name('set.subjects');
            Route::get('/promote-or-demote-students/{classroom:slug}', 'promoteOrDemoteStudents')->name('promote.or.demote.students');
            Route::post('/update-subjects/{classroom:slug}', 'updateSubjects')->name('update.subjects');
            Route::post('/promote-students/{classroom:slug}', 'promoteStudents')->name('promote.students');
            Route::post('/demote-students/{classroom:slug}', 'demoteStudents')->name('demote.students');
            Route::post('/store', 'store')->name('store');
            Route::patch('/update/{classroom:slug}', 'update')->name('update');
            Route::patch('/update-branches/{classroom:slug}', 'updateBranches')->name('update.branches');
            Route::delete('/delete/{classroom:slug}', 'destroy')->name('destroy');
        });

        Route::controller(TermController::class)->prefix('terms')->name('term.')->group(function () {
            //Term routes
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{term:slug}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::patch('/update/{term:slug}', 'update')->name('update');
            Route::delete('/delete/{term:slug}', 'destroy')->name('destroy');
        });

        Route::controller(SubjectController::class)->prefix('subjects')->name('subject.')->group(function () {
            // Subject routes
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{subject:slug}', 'edit')->name('edit');
            Route::post('/store',  'store')->name('store');
            Route::patch('/update/{subject:slug}',  'update')->name('update');
            Route::delete('/delete/{subject:slug}',  'destroy')->name('destroy');
        });

        Route::controller(AcademicSessionIndex::class)->prefix('academic-sessions')->name('academic-session.')->group(function () {
            //AcademicSession routes
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{academicSession:name}', 'edit')->name('edit');
            Route::patch('/update/{academicSession:name}', 'update')->name('update');
        });

        Route::controller(GuardianController::class)->prefix('guardians')->name('guardian.')->group(function () {
            //Guardian Routes
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/show/{guardian:phone}', 'show')->name('show');
            Route::get('/edit/{guardian:phone}', 'edit')->name('edit');
            Route::patch('/update/{guardian:phone}', 'update')->name('update');
            Route::post('/change-guardian/{student}', 'changeGuardian')->name('change');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{guardian}', 'destroy')->name('destroy');
        });

        Route::controller(PDTypeController::class)->prefix('pd-types')->name('pd-type.')->group(function () {
            //Pychomotor domain type routes
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{pdType:slug}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::patch('/update/{pdType}', 'update')->name('update');
            Route::delete('/delete/{pdType}', 'destroy')->name('destroy');
        });

        Route::controller(ADTypeController::class)->prefix('ad-types')->name('ad-type.')->group(function () {
            //Affective domain type routes
            Route::get('/',  'index')->name('index');
            Route::get('/edit/{adType:slug}',  'edit')->name('edit');
            Route::post('/store',  'store')->name('store');
            Route::patch('/update/{adType}',  'update')->name('update');
            Route::delete('/delete/{adType}',  'destroy')->name('destroy');
        });

        Route::controller(PeriodController::class)->prefix('period')->name('period.')->group(function () {
            Route::get('/',  'index')->name('index');
            Route::get('/edit/{period:slug}',  'edit')->name('edit');
            Route::post('/store',  'store')->name('store');
            Route::patch('/update/{period:slug}',  'update')->name('update');
            Route::patch('/set-active/{period:slug}',  'setActivePeriod')->name('set-active-period');
            Route::delete('/delete/{period:slug}',  'destroy')->name('delete');
        });

        Route::controller(FeeController::class)->prefix('fee')->name('fee.')->group(function () {
            Route::get('/',  'index')->name('index');
            Route::post('/store',  'store')->name('store');
            Route::get('/edit/{fee}',  'edit')->name('edit');
            Route::patch('/update/{fee}',  'update')->name('update');
            Route::delete('/delete/{fee}',  'destroy')->name('destroy');
        });

        Route::get('email-class-performace-report/{classroom}', [ResultController::class, 'sendClassroomPerformanceReportEmail'])->name('email.class.performace.report');
    });
});

require __DIR__ . '/auth.php';
