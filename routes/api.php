<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\LecturersController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Course_LecturersController;

use App\Models\User;
use App\Models\Students;
use App\Models\Courses;
use App\Models\Lecturers;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    
    Route::post('/logout', [AuthController::class, 'logout']);

    
    Route::get('/dashboard-counts', function () {
        return response()->json([
            'total_users'     => \App\Models\User::count(),
            'total_students'  => \App\Models\Students::count(),
            'total_courses'   => \App\Models\Courses::count(),
            'total_lecturers' => \App\Models\Lecturers::count(),
            'total_course_lecturers' => \App\Models\Course_Lecturers::count(),
            'total_enrollment' => \App\Models\Enrollment::count(),
        ]);
    });

    Route::apiResource('user', UserController::class);
    Route::apiResource('students', StudentsController::class);
    Route::apiResource('courses', CoursesController::class);
    // Route::apiResource('enrollment', EnrollmentController::class);
    Route::apiResource('lecturers', LecturersController::class);
    Route::apiResource('course_lecturers', Course_LecturersController::class);
    Route::apiResource('enrollment', EnrollmentController::class)->parameters([
    'enrollment' => 'enrollment_id',
]);
});
