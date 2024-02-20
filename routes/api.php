<?php

use App\Http\Controllers\api\AnnouncementController;
use App\Http\Controllers\api\ApprovalController;
use App\Http\Controllers\api\AttendanceController;
use App\Http\Controllers\api\KoperasiController;
use App\Http\Controllers\api\OvertimeController;
use App\Http\Controllers\api\ScheduleListController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\TimeoffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::get('division', [UserController::class, 'division']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('/timezone', [UserController::class, 'get_timezone']);
    Route::post('/update-password', [UserController::class, 'updatePassword']);
    Route::post('/reset-to-default-password', [UserController::class, 'resetToDefaultPassword']);
    Route::post('/update-photo-profile/{id}', [EmployeeController::class, 'updateProfilePicture']);
    Route::get('/karyawan', [UserController::class, 'getAllKaryawan']);
    Route::get('/itung/cuti/{id}', [AttendanceController::class, 'countTimeoff']);
    Route::get('/count/cuti', [AttendanceController::class, 'countTimeoffAllUser']);

    // overtime
    Route::post('overtime/request', [OvertimeController::class, 'store']);
    Route::get('overtime/show/{id}', [OvertimeController::class, 'view']);
    Route::post('overtime/approve/{id}', [ApprovalController::class, 'overtimeUpdate']);
    // timeoff
    Route::post('timeoff', [TimeoffController::class, 'store']);
    Route::get('timeoff/show/{id}', [TimeoffController::class, 'view']);
    // shift
    Route::get('shift/show/{id}', [shiftController::class, 'view']);
    Route::post('shift/request', [shiftController::class, 'store']);
    // live attendance
    Route::get('request-attendance/show/{id}', [AttendanceController::class, 'show']);
    Route::get('attendance', [AttendanceController::class, 'fetch']);
    Route::get('attendance/{id}', [AttendanceController::class, 'showDetail']);
    Route::post('live-attendance/check', [AttendanceController::class, 'cekCordinate']);
    Route::post('request-attendance', [AttendanceController::class, 'AttendanceRequest']);
    Route::post('live-attendance', [AttendanceController::class, 'store']);

    // Request of Approval
    Route::get('request/list', [ApprovalController::class, 'pengajuan']);
    Route::get('approval/list', [ApprovalController::class, 'approvalPengajuan']);
    Route::get('approval/count', [ApprovalController::class, 'countApprovalPengajuan']);
    Route::get('detail-approval', [ApprovalController::class, 'detailPengajuan']);

    // Approval request
    Route::post('timeoff/approve/{id}', [ApprovalController::class, 'timeoffUpdate']);
    Route::post('outofrange/approve/{id}', [ApprovalController::class, 'approvalRadiusUpdate']);
    Route::post('attendance/approve/{id}', [ApprovalController::class, 'AttendanceRequest']);

    // shift
    Route::post('shift', [ScheduleController::class, 'shift']);
    Route::get('shift', [ScheduleController::class, 'shiftList']);
    //
    Route::post('count-workday', [ScheduleController::class, 'count']);

    // timeoff
    Route::post('register/timeoff', [ScheduleController::class, 'timeoff']);
    Route::get('list/timeoff', [ScheduleController::class, 'timeoffList']);
    Route::get('scheduler/cuti-tahunan/dum', [TimeoffController::class, 'scheduleDum']);
    Route::get('scheduler/cuti-tahunan/dui', [TimeoffController::class, 'scheduleDui']);
    // schedule
    Route::post('schedule', [ScheduleController::class, 'schedule']);
    Route::get('schedule', [ScheduleController::class, 'scheduleList']);
    // location
    Route::post('location', [ScheduleController::class, 'location']);
    Route::get('location', [ScheduleController::class, 'locationList']);
    // organization
    Route::post('organization', [ScheduleController::class, 'organization']);
    Route::get('organization', [ScheduleController::class, 'organizationList']);
    // department
    Route::post('department', [ScheduleController::class, 'department']);
    Route::get('department', [ScheduleController::class, 'departmentList']);

    // announcement
    Route::POST('announcement/store', [AnnouncementController::class, 'store']);
    Route::get('announcement', [AnnouncementController::class, 'apiList']);
    Route::get('announcement/{id}', [AnnouncementController::class, 'apiShow']);
    //schedule
    Route::post('holiday_date/{year?}', [ScheduleListController::class, 'holiday_date']);
    Route::get('calendar/{month?}/{year?}', [ScheduleListController::class, 'narik_libur']);
    Route::get('shifttoday/{user_id?}/{date?}', [ScheduleListController::class, 'getshifttoday']);
    // filter api
    //koperasi
    Route::post('check_koperasi', [KoperasiController::class, 'check_koperasi']);
});

Route::post('login', [UserController::class, 'login']);
Route::get('avatar', [UserController::class, 'create_avatar']);
// Route::get('announcement', [AnnouncementController::class, 'index']);
