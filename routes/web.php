<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\Google2FAController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfessionalSummariesController;
use App\Http\Controllers\Admin\ExperiencesController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\SkillsController;
use App\Http\Controllers\Admin\CertificationsController;
use App\Http\Controllers\Admin\EducationsController;

Route::get('/administrator', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('postLogin')->middleware('throttle:3,1');

// Logout Route
Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');


// 2FA Routes
Route::prefix('/google2fa')->group(function () {
    Route::get('/register', [Google2FAController::class, 'register'])->name('google2fa.register');
    Route::post('/register', [Google2FAController::class, 'store'])->name('google2fa.store');
    Route::get('/verify', [Google2FAController::class, 'verify'])->name('google2fa.verify');
    Route::post('/verify', [Google2FAController::class, 'check'])->name('google2fa.check');
});

Route::get('/', [PortfolioController::class, 'index'])->name('welcome');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/project/{id}', [PortfolioController::class, 'project'])->name('project.show');
Route::get('/download-resume', [PortfolioController::class, 'downloadResume'])->name('resume.download');
Route::post('/contact/send', [PortfolioController::class, 'sendContact'])->name('contact.send');

// Admin routes (for managing portfolio content)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    // Profile
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
        Route::post('/change-picture', [ProfileController::class, 'changePicture'])->name('profile.change.picture');
    });

    // Professional Summaries
    Route::prefix('/summary')->group(function () {
        Route::get('/', [ProfessionalSummariesController::class, 'index'])->name('summary.index');
        Route::post('/update', [ProfessionalSummariesController::class, 'update'])->name('summary.update');
    });

    // Educations
    Route::prefix('/educations')->group(function () {
        Route::get('/', [EducationsController::class, 'index'])->name('educations.index');
        Route::post('/', [EducationsController::class, 'showEducationsData'])->name('educations.show.data');
        Route::post('/store', [EducationsController::class, 'store'])->name('educations.store');
        Route::post('/update', [EducationsController::class, 'update'])->name('educations.update');
        Route::post('/delete', [EducationsController::class, 'delete'])->name('educations.delete');
        Route::post('/restore', [EducationsController::class, 'restore'])->name('educations.restore');
    });

    // Experiences
    Route::prefix('/experiences')->group(function () {
        Route::get('/', [ExperiencesController::class, 'index'])->name('experiences.index');
        Route::post('/', [ExperiencesController::class, 'showExperiencesData'])->name('experiences.show.data');
        Route::post('/store', [ExperiencesController::class, 'store'])->name('experiences.store');
        Route::post('/update', [ExperiencesController::class, 'update'])->name('experiences.update');
        Route::post('/delete', [ExperiencesController::class, 'delete'])->name('experiences.delete');
        Route::post('/restore', [ExperiencesController::class, 'restore'])->name('experiences.restore');
    });

    // Projects
    Route::prefix('/projects')->group(function () {
        Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
        Route::post('/', [ProjectsController::class, 'showProjectsData'])->name('projects.show.data');
        Route::post('/store', [ProjectsController::class, 'store'])->name('projects.store');
        Route::post('/update', [ProjectsController::class, 'update'])->name('projects.update');
        Route::post('/delete', [ProjectsController::class, 'delete'])->name('projects.delete');
        Route::post('/restore', [ProjectsController::class, 'restore'])->name('projects.restore');
    });

    // Skills
    Route::prefix('/skills')->group(function () {
        Route::get('/', [SkillsController::class, 'index'])->name('skills.index');
        Route::post('/', [SkillsController::class, 'showSkillsData'])->name('skills.show.data');
        Route::post('/store', [SkillsController::class, 'store'])->name('skills.store');
        Route::post('/update', [SkillsController::class, 'update'])->name('skills.update');
        Route::post('/delete', [SkillsController::class, 'delete'])->name('skills.delete');
        Route::post('/restore', [SkillsController::class, 'restore'])->name('skills.restore');
    });

    // Certifications
    Route::prefix('/certifications')->group(function () {
        Route::get('/', [CertificationsController::class, 'index'])->name('certifications.index');
    });
});
