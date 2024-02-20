<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\api\AnnouncementController;
use App\Http\Controllers\api\ApprovalController;
use App\Http\Controllers\api\OvertimeController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\TimeoffController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\SettingCutiController;
use App\Http\Controllers\UserUpdateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('login');
});
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::post('sign-in', [UserController::class, 'loginpost'])->name('login.post');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
// roles
Route::resource('permission', 'PermissionController');
Route::resource('role', 'RolesController');
Route::post('role/role-user/add', [RolesController::class, 'addOrEditRoleUser'])->name('addOrEditRole');
Route::get('role/role-user/delete/{id}', [RolesController::class, 'deleteRoleUser'])->name('deleteRoleUser');
// Employee
Route::resource('employee', 'EmployeeController');
Route::get('list_employees', [EmployeeController::class, 'list_employee'])->name('list_employees');
Route::get('filter_employees/{status}/{department}/{division}', [EmployeeController::class, 'filter_employees'])->name('filter_employees');
Route::post('import/karyawan', [UserController::class, 'import_excel'])->name('import.karyawan');
Route::get('export/karyawan', [UserController::class, 'export_excel'])->name('export.karyawan');
Route::get('karyawan/reset-password/{id}', [EmployeeController::class, 'reset_password'])->name('reset.password');
Route::get('detail_employee/{id}', [EmployeeController::class, 'show'])->name('detail_employee');
Route::post('insight/{id}', [EmployeeController::class, 'insight'])->name('insight');

// Internal Memo
Route::resource('internal_memo', 'api\AnnouncementController');
Route::get('publish/memo/{id}', [AnnouncementController::class, 'publish'])->name('publish.memo');
// Overtime
Route::resource('overtime', 'api\OvertimeController');
Route::get('filter_req_overtime', [OvertimeController::class, 'filter_req_overtime'])->name('overtime.filter_req_overtime');
Route::post('export/overtime', [OvertimeController::class, 'export_excel'])->name('export.overtime');
// Location
Route::resource('location', 'LocationController');
Route::post('location/edit/{id}', [LocationController::class, 'edit_location'])->name('edit-location');
Route::post('import/lokasi', [LocationController::class, 'import_excel'])->name('import.location');
// Organization
Route::resource('organization', 'OrganizationController');
Route::post('edit-organization/{id}', [OrganizationController::class, 'edit_organization'])->name('edit-organization');
// Division
Route::resource('division', 'DivisionController');
// Department
Route::resource('department', 'DepartmentController');
// Position
Route::resource('position', 'PositionController');
// Job Position
Route::resource('job-position', 'JobPositionController');
Route::post('job-posisi/edit/{id}', [JobPositionController::class, 'edit_job_posisi'])->name('edit.job.posisi');
// Timeoff
Route::resource('time_off', 'TimeoffController');
Route::post('export/timeoff', [TimeoffController::class, 'export_excel'])->name('export.timeoff');
Route::get('filter_req_timeoff', [TimeoffController::class, 'filter_req_timeoff'])->name('time_off.filter_req_timeoff');
// Out Of Range
Route::get('out-of-range', [AbsenceController::class, 'index_out_of_range'])->name('outofrange.index');
Route::get('filter_out_of_range', [AbsenceController::class, 'filter_out_of_range'])->name('outofrange.filter_out_of_range');
Route::get('attendance-index', [AbsenceController::class, 'index_attendance'])->name('attendance.index');
Route::get('filter_request_attendence', [AbsenceController::class, 'filter_req_attendance'])->name('attendance.filter_req_attendance');
// Absence
Route::resource('report_absence', 'AbsenceController');
Route::post('absence/employee/{id}', 'AbsenceController@admin_create')->name('absence.create');
Route::get('filter_Abesnt', [AbsenceController::class, 'filter_Abesnt'])->name('absence.filter_Abesnt');
Route::get('filter_user_Abesnt', [AbsenceController::class, 'filter_user_Abesnt'])->name('absence.filter_user_Abesnt');
Route::get('absensi', [AbsenceController::class, 'apiAbsensi']);
// Schedule
Route::resource('schedule', 'ScheduleController');
Route::get('edit-shift/{id}', [ScheduleController::class, 'edit_shift'])->name('edit.shift');
Route::post('update-shift/{id}', [ScheduleController::class, 'update_shift'])->name('update.shift');
Route::post('export/jadwal', [ScheduleController::class, 'export_excel'])->name('export.jadwal');
Route::post('edit-schedule/{id}', [ScheduleController::class, 'edit_schedule'])->name('edit-schedule');
// Timeoff
Route::resource('setting_time_off', 'SettingCutiController');
Route::post('mass-leave', 'SettingCutiController@mass_leave')->name('mass.leave');
Route::get('list_timeoff', [SettingCutiController::class, 'list_timeoff'])->name('list_timeoff');
Route::resource('cuti-tahunan', 'CutiTahunanController');
Route::get('setting/cuti/export', [TimeoffController::class, 'kuotaexport_excel'])->name('kuota.export');
// Import Roster Dum
Route::get('roster', [RosterController::class, 'index'])->name('roster');
Route::post('roster/import', [RosterController::class, 'import'])->name('roster.import');
Route::get('roster/show-roster/{id}', [RosterController::class, 'show'])->name('roster.show-roster');
Route::get('roster/detail-roster/{id}', [RosterController::class, 'detail'])->name('roster.detail-roster');
Route::post('roster/update-roster/{id}', [RosterController::class, 'update'])->name('roster.update-roster');
Route::get('roster/list_rosters', [RosterController::class, 'list_rosters'])->name('roster.list_rosters');
Route::get('roster/jadwal_roster/{id}', [RosterController::class, 'filter_jadwal_roster'])->name('roster.jadwal_roster');
// Approval
Route::post('timeoff/admin/{id}', [ApprovalController::class, 'timeoffUpdate'])->name('admin.timeoff');
Route::post('overtime/admin/{id}', [ApprovalController::class, 'overtimeUpdate'])->name('admin.overtime');
// logout
Route::get('/logout-admin', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout-admin');


// Route::resource('user-update', 'UserUpdateController');
Route::get('/user-update', [UserUpdateController::class, 'index'])->name('up.index');
Route::post('/user-update/home', [UserUpdateController::class, 'login'])->name('up.login');
Route::post('/user-update/update_employee', [UserUpdateController::class, 'update_employee'])->name('up.update_employee');
// Route::get('/user-update/logout', [UserUpdateController::class, 'logout'])->name('up.logout');


