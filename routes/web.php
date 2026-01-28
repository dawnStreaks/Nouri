<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialTransferController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminTransferController;
use App\Http\Controllers\StoreTransferController;
use App\Http\Controllers\DeliveryTransferController;
use App\Http\Controllers\AdminDashboardController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [MaterialTransferController::class, 'index'])->name('material-transfer.index');
    Route::get('/transfer/{route}', [MaterialTransferController::class, 'create'])->name('material-transfer.create');
    Route::get('/records/{route}', [MaterialTransferController::class, 'show'])->name('material-transfer.show');
    Route::get('/edit/{id}', [MaterialTransferController::class, 'edit'])->name('material-transfer.edit');
    Route::put('/update/{id}', [MaterialTransferController::class, 'update'])->name('material-transfer.update');
    Route::post('/update/{id}', [MaterialTransferController::class, 'update']);
    Route::get('/next-sl/{route}', [MaterialTransferController::class, 'getNextSlNo'])->name('material-transfer.next-sl');
    Route::get('/material-transfer/store', function() {
        return redirect()->route('material-transfer.index');
    });
    Route::post('/material-transfer/store', [MaterialTransferController::class, 'store'])->name('material-transfer.store');
    Route::post('/approve/{id}', [MaterialTransferController::class, 'approve'])->name('material-transfer.approve');
    Route::post('/approve-group', [MaterialTransferController::class, 'approveGroup'])->name('material-transfer.approve-group');
    Route::post('/ready-for-collection/{id}', [MaterialTransferController::class, 'readyForCollection'])->name('material-transfer.ready-for-collection');
    Route::post('/collect/{id}', [MaterialTransferController::class, 'collect'])->name('material-transfer.collect');
    Route::get('/collect-group', function() {
        return redirect()->back();
    });
    Route::post('/collect-group', [MaterialTransferController::class, 'collectGroup'])->name('material-transfer.collect-group');
    Route::post('/collect-group', [MaterialTransferController::class, 'collectGroup'])->name('material-transfer.collect-group');
    Route::post('/finish/{id}', [MaterialTransferController::class, 'finish'])->name('material-transfer.finish');
    Route::post('/finish-group', [MaterialTransferController::class, 'finishGroup'])->name('material-transfer.finish-group');
    Route::post('/received/{id}', [MaterialTransferController::class, 'received'])->name('material-transfer.received');
    Route::get('/approve-group', function() {
        return redirect()->back();
    });
    Route::post('/approve-group', [MaterialTransferController::class, 'approveGroup'])->name('material-transfer.approve-group');
    Route::get('/received-group', function() {
        return redirect()->back();
    });
    Route::post('/received-group', [MaterialTransferController::class, 'receivedGroup'])->name('material-transfer.received-group');
    Route::post('/received-group', [MaterialTransferController::class, 'receivedGroup'])->name('material-transfer.received-group');
    
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Role-specific transfer routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::post('/admin/request/{id}', [AdminTransferController::class, 'request'])->name('admin.transfer.request');
        Route::post('/admin/finish/{id}', [AdminTransferController::class, 'finish'])->name('admin.transfer.finish');
    });

    Route::middleware(['auth', 'role:store'])->group(function () {
        Route::put('/store/update-qty/{id}', [StoreTransferController::class, 'updateQuantity'])->name('store.transfer.update-qty');
        Route::post('/store/collect/{id}', [StoreTransferController::class, 'collect'])->name('store.transfer.collect');
    });

    Route::middleware(['auth', 'role:delivery'])->group(function () {
        Route::post('/delivery/receive/{id}', [DeliveryTransferController::class, 'receive'])->name('delivery.transfer.receive');
    });
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    
    // Admin Panel Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        
        // Transfer Management
        Route::get('/transfers', [App\Http\Controllers\Admin\AdminController::class, 'transfersIndex'])->name('transfers.index');
        Route::get('/transfers/create', [App\Http\Controllers\Admin\AdminController::class, 'transfersCreate'])->name('transfers.create');
        Route::get('/transfers/pending', [App\Http\Controllers\Admin\AdminController::class, 'transfersPending'])->name('transfers.pending');
        Route::get('/transfers/routes', [App\Http\Controllers\Admin\AdminController::class, 'transfersRoutes'])->name('transfers.routes');
        
        // User Management
        Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\AdminController::class, 'usersCreate'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\Admin\AdminController::class, 'usersStore'])->name('users.store');
        Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'usersEdit'])->name('users.edit');
        Route::put('/users/{id}', [App\Http\Controllers\Admin\AdminController::class, 'usersUpdate'])->name('users.update');
        Route::get('/roles', [App\Http\Controllers\Admin\AdminController::class, 'rolesIndex'])->name('roles.index');
        
        // Inventory Management
        Route::get('/parts', [App\Http\Controllers\Admin\AdminController::class, 'partsIndex'])->name('parts.index');
        Route::get('/inventory', [App\Http\Controllers\Admin\AdminController::class, 'inventoryIndex'])->name('inventory.index');
        Route::get('/suppliers', [App\Http\Controllers\Admin\AdminController::class, 'suppliersIndex'])->name('suppliers.index');
        
        // Company Management
        Route::get('/companies', [App\Http\Controllers\Admin\AdminController::class, 'companiesIndex'])->name('companies.index');
        Route::get('/companies/{company}/transfers', [App\Http\Controllers\Admin\AdminController::class, 'companyTransfers'])->name('companies.transfers');
        Route::get('/departments', [App\Http\Controllers\Admin\AdminController::class, 'departmentsIndex'])->name('departments.index');
        
        // Reports
        Route::get('/reports/transfers', [App\Http\Controllers\Admin\AdminController::class, 'reportsTransfers'])->name('reports.transfers');
        Route::get('/reports/inventory', [App\Http\Controllers\Admin\AdminController::class, 'reportsInventory'])->name('reports.inventory');
        Route::get('/reports/users', [App\Http\Controllers\Admin\AdminController::class, 'reportsUsers'])->name('reports.users');
        
        // System
        Route::get('/settings', [App\Http\Controllers\Admin\AdminController::class, 'settingsIndex'])->name('settings.index');
        Route::get('/logs', [App\Http\Controllers\Admin\AdminController::class, 'logsIndex'])->name('logs.index');
        Route::get('/backup', [App\Http\Controllers\Admin\AdminController::class, 'backupIndex'])->name('backup.index');
    });
});
