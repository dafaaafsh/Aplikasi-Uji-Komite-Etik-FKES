<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KepkController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PengujiController;
use App\Http\Controllers\PenelitiController;
use App\Http\Controllers\KeputusanController;
use App\Http\Controllers\PasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Halaman umum
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [SesiController::class,'logout'])->name('logout');    

route::middleware('guest')->group(function(){
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [SesiController::class, 'login']);
    Route::get('/signin', [HomeController::class, 'signin'])->name('signin');
    Route::post('/signin', [SesiController::class, 'store'])->name('siginStore');
});


// Peneliti
Route::middleware(['auth', RoleMiddleware::class . ':Peneliti'])->group(function () {
    Route::get('/peneliti/dashboard', [PenelitiController::class, 'dashboard'])->name('peneliti.dashboard');

    Route::middleware(['verified'])->group(function () {
        Route::get('/peneliti/penelitian', [PenelitiController::class, 'penelitian'])->name('peneliti.penelitian');
        Route::get('/peneliti/penelitian/detail/{id}', [PenelitiController::class, 'getDetailPenelitian'])->name('peneliti.penelitian.detail');
        Route::get('/peneliti/penelitian/review/{id}', [KepkController::class, 'getDetailReview'])->name('peneliti.detailReview');
        Route::get('/peneliti/penelitian/keputusan/{id}', [PenelitiController::class, 'getKeputusan']);
        Route::get('/peneliti/nomorProtokol', [PenelitiController::class, 'nomorProtokol'])->middleware('verified')->name('peneliti.nomorProtokol');
        Route::post('/peneliti/nomorProtokol',[PenelitiController::class, 'storeNomor']);
        Route::get('/peneliti/protokol/{id}',[PenelitiController::class, 'getDetailProtokol'])->name('peneliti.protokol.detail');
        Route::post('/peneliti/nomorProtokol/upload',[PenelitiController::class, 'uploadBukti'])->name('peneliti.upload.bukti');
        Route::get('/peneliti/pengajuanPenelitian', [PenelitiController::class, 'pengajuan'])->name('peneliti.pengajuan');
        Route::post('/peneliti/pengajuanPenelitian/storeDocument', [PenelitiController::class, 'storeDocument'])->name('pengajuan.store');
        Route::post('/peneliti/pengajuanPenelitian/updateDocument', [PenelitiController::class, 'updateDocument'])->name('update.store');
        Route::post('/peneliti/pengajuanPenelitian/updateGDriveLink', [PenelitiController::class, 'updateGDriveLink'])->name('peneliti.pengajuan.updateGDriveLink');
        Route::get('/peneliti/template', [HomeController::class,'template'])->name('template');
        Route::get('/peneliti/penelitian/gdrive-link/{id}', [PenelitiController::class, 'getGDriveLink'])->name('peneliti.penelitian.gdrive-link');
    });
    
    Route::get('/Peneliti/profil', [PenelitiController::class, 'profil'])->name('peneliti.profil');
    Route::post('Peneliti/profil/update',[PenelitiController::class, 'updateData'])->name('peneliti.profil.update');
    Route::post('Peneliti/profil/uploadImage',[PenelitiController::class, 'uploadAvatar'])->name('peneliti.profil.uploadAvatar');
    Route::get('/peneliti/tentangKami', [HomeController::class,'tentang'])->name('tentang.kami');
});

// Admin
Route::middleware(['auth', RoleMiddleware::class . ':Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/kelolaUser', [AdminController::class, 'kelolaUser'])->name('admin.kelolaUser');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/admin/users/update', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::post('/admin/users/destroy', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');
    Route::get('/admin/users/detail/{id}', [AdminController::class, 'detailUser'])->name('admin.users.detail');

    Route::middleware(['verified'])->group(function () {
        Route::get('/admin/nomorProtokol', [AdminController::class,'nomorProtokol'])->name('admin.nomorProtokol');
        Route::post('/admin/nomorProtokol/tarif', [AdminController::class, 'updateTarif'])->name('admin.tarifProtokol.update');
        Route::get('/admin/nomorProtokol/bukti/{id}', [AdminController::class,'getBukti'])->name('admin.bukti');
        Route::post('/admin/protokol/tolak-bukti/{id}', [AdminController::class, 'tolakBukti']);
        Route::post('/admin/protokol/terima-bukti/{id}', [AdminController::class, 'terimaBukti']);  
        Route::get('/admin/nomorProtokol/{id}', [AdminController::class, 'getDetail'])->name('admin.protokol.detail');
        Route::post('/admin/nomorProtokol/update', [AdminController::class, 'storeNomor'])->name('admin.nomorProtokol.update');
        Route::get('/admin/pengajuanPenelitian', [AdminController::class,'pengajuanPenelitian'])->name('admin.pengajuanPenelitian');
        Route::get('/admin/pengajuanPenelitian/{id}', [AdminController::class, 'getDetailPengajuan'])->name('admin.detailPengajuan');
        Route::put('/admin/pengajuanPenelitian/kembalikan', [ AdminController::class, 'kembalikan'])->name('admin.kembalikan');
        Route::put('/admin/pengajuanPenelitian/lanjutkan', [ AdminController::class, 'lanjutkan'])->name('admin.lanjutkan');
        Route::get('/admin/dataPenelitian', [AdminController::class, 'dataPenelitian'])->name('admin.dataPenelitian');
        Route::get('/admin/dataPenelitian/detail/{id}', [AdminController::class, 'getDataPenelitian'])->name('admin.detailDataPenelitian');
        Route::post('/admin/suratLulus/upload/{id}', [AdminController::class, 'uploadSuratLulus'])->name('admin.uploadSuratLulus');
        Route::get('/admin/suratLulus', [AdminController::class, 'suratLulus'])->name('admin.suratLulus');
        Route::get('/admin/protokol/{id}/data',[AdminController::class, 'getDataProtokol'])->name('admin.protokol.data');
        Route::post('/admin/suratLulus/store', [AdminController::class, 'storeSurat'])->name('admin.surat-lulus.store');
    });

    Route::get('/Admin/profil', [AdminController::class, 'profil'])->name('admin.profil');
    Route::post('Admin/profil/update',[PenelitiController::class, 'updateData'])->name('admin.profil.update');
    Route::post('Admin/profil/uploadImage',[PenelitiController::class, 'uploadAvatar'])->name('admin.profil.uploadAvatar');
});

//Sekretaris/KEPK
Route::middleware(['auth', RoleMiddleware::class . ':Kepk'])->group(function () {
    Route::get('/kepk/dashboard', [KepkController::class, 'dashboard'])->name('kepk.dashboard');
    Route::get('/kepk/dataPenelitian', [KepkController::class, 'dataPenelitian'])->name('kepk.dataPenelitian');

    Route::middleware(['verified'])->group(function () {
        Route::get('/kepk/telaahAwal', [KepkController::class, 'telaahAwal'])->name('kepk.telaahAwal');
        Route::post('/admin/pengajuanPenelitian/exempted', [ KepkController::class, 'exempted'])->name('kepk.exempted');
        Route::put('/admin/pengajuanPenelitian/expedited', [ KepkController::class, 'expedited'])->name('kepk.expedited');
        Route::put('/admin/pengajuanPenelitian/fullboard', [ KepkController::class, 'fullboard'])->name('kepk.fullboard');
        Route::get('/kepk/telaahAkhir', [KepkController::class, 'telaahAkhir'])->name('kepk.telaahAkhir');
        Route::get('/kepk/telaahAkhir/{id}', [AdminController::class, 'getDetailPengajuan'])->name('kepk.detailAkhir');
        Route::get('/kepk/telaahAkhir/review/{id}', [KepkController::class, 'getDetailReview'])->name('kepk.detailReview');
        Route::post('/kepk/telaahAkhir/keputusan', [KeputusanController::class, 'store'])->name('kepk.keputusan.store');
    });

    route::get('/Kepk/profil', [kepkController::class,'profil'])->name('kepk.profil');
    Route::post('Kepk/profil/update',[PenelitiController::class, 'updateData'])->name('kepk.profil.update');
    Route::post('Kepk/profil/uploadImage',[PenelitiController::class, 'uploadAvatar'])->name('kepk.profil.uploadAvatar');
});

//Penguji
Route::middleware(['auth', RoleMiddleware::class . ':Penguji'])->group(function () {
    Route::get('/penguji/dashboard', [PengujiController::class, 'dashboard'])->name('penguji.dashboard');
    Route::get('/protokol/{id}', [PengujiController::class, 'show'])->name('penguji.protokol.show');
    Route::get('/penguji/dataPenelitian', [PengujiController::class, 'dataPenelitian'])->name('penguji.dataPenelitian');
    Route::get('/penguji/dataPenelitian/{id}', [AdminController::class, 'getDetailPengajuan'])->name('penguji.detailData');

    Route::middleware(['verified'])->group(function () {
        Route::get('/penguji/telaahPenelitian', [PengujiController::class, 'telaahPenelitian'])->name('penguji.telaahPenelitian');
        Route::post('/penguji/review/{protokol}', [ReviewController::class, 'store'])->name('review.store');
    });

    Route::get('/Penguji/profil', [PengujiController::class,'profil'])->name('kepk.profil');
    Route::post('Penguji/profil/update',[PenelitiController::class, 'updateData'])->name('penguji.profil.update');
    Route::post('Penguji/profil/uploadImage',[PenelitiController::class, 'uploadAvatar'])->name('penguji.profil.uploadAvatar');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
});

// akses file
//file protokol
Route::get('/private/protokol/{nomor_protokol}/{filename}', function ($nomor_protokol,$filename){
    $path = storage_path('app/private/protokol/'.$nomor_protokol.'/'.$filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

//file avatar
Route::get('/public/avatars/{filename}', function ($filename){
    $path = storage_path('app/public/avatars'.'/'.$filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

//file lampiran
Route::get('/private/lampiran/{nomor_protokol}/{filename}', function ($nomor_protokol,$filename){
    $path = storage_path('app/private/lampiran/'.$nomor_protokol.'/'.$filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

//file template
Route::get('/template/view/{filename}', function ($filename) {
    $path = storage_path('app/private/template/' . $filename);

    if (!File::exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $mime = File::mimeType($path);

    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => str_contains($mime, 'pdf') ? 'inline' : 'attachment'
    ]);
})->where('filename', '.*')->middleware('auth');

//file pembayaran
Route::get('/private/pembayaran/{filename}', function ($filename){
    $path = storage_path('app/private/pembayaran/'.$filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

// file KTP
Route::get('/private/ktp/{filename}', function ($filename){
    $path = storage_path('app/private/ktp/'.$filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

// verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email', ['title' => '']);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/Peneliti/profil');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/check-email', function (Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $exists = \App\Models\User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
});
?>