<?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\BotAdminController;
    use App\Http\Controllers\Admin\QuestionController;
    use App\Http\Controllers\Admin\OrganizationController;
    use App\Http\Controllers\Admin\LeadAdminController;
    use App\Http\Controllers\DashboardController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // 🛡️ Group Question admin routes
    Route::prefix('admin')
    ->middleware(['auth'])
    ->name('admin.')
    ->group(function () {
        // Organization CRUD
        Route::resource('organizations', OrganizationController::class);

        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 📋 Bot Questions CRUD
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

         // 🧲 Leads Management
        Route::get('/leads', [LeadAdminController::class, 'index'])->name('leads.index');
        Route::get('/leads/{lead}', [LeadAdminController::class, 'showLead'])->name('leads.show');

    });

require __DIR__.'/auth.php';
