<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Untuk Dewan Pengurus Provinsi DKI
|--------------------------------------------------------------------------
|
|
*/

Route::group(['prefix' => 'v1'], function () {
    // Route::get('/', function () {
    //     return [
    //         'app' => 'KTA ONLINE INKINDO SERVICE API',
    //         'version' => '1.0.0',
    //     ];
    // });

    Route::group(['prefix' => 'dki'], function () {
       /*
    |--------------------------------------------------------------------------
    | Sign In DPP DKI
    |--------------------------------------------------------------------------
    |
    */
    Route::post('/signin', 'Dki\Auth\AuthController@signin')->name('auth.signin');
    /*
    |--------------------------------------------------------------------------
    | Password reset DPP DKI
    |--------------------------------------------------------------------------
    |
    */
    Route::post('/reset', 'Dki\Auth\AuthController@reset')->name('auth.reset');
    /*
    |--------------------------------------------------------------------------
    | Sign out DPP DKI
    |--------------------------------------------------------------------------
    |
    */
    Route::post('/signout', 'Dki\Auth\AuthController@signout')->name('auth.signout');
    
    // All Routes With JWT
    Route::group(['middleware' => ['jwt']], function () {
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Registrasi Anggota>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/registrasi-anggota', 'Dki\PengajuanAnggotaController@register')->name('registration.registrasi-anggota');
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Get anggota berdasarkan ID DP DKI>
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/pengajuan/anggota-berdarkan-provinsi', 'Dki\PengajuanAnggotaController@getAnggotaByIdDp')->name('registration.anggota-by-provinsi');
   
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Info Umum Badan Usaha>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/info-umum-bu', 'Dki\PengajuanAnggotaController@infoUmumBadanUsaha')->name('registration.info-umum-bu');
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Administrasi Badan Usaha>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/administrasi-bu', 'Dki\PengajuanAnggotaController@administrasiBadanUsaha')->name('registration.administrasi-bu');
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Penanggung Jawab Badan Usaha>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/penanggung-jawab-bu', 'Dki\PengajuanAnggotaController@penanggungJawabBadanUsaha')->name('registration.pj-bu');
       /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Legalitas Badan Usaha>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/legalitas-bu', 'Dki\PengajuanAnggotaController@legalitasBadanUsaha')->name('registration.legalitas-bu');
        /*
        |--------------------------------------------------------------------------
        | Submit Pengajuan anggota <Upload Dokumen Pendukung>
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pengajuan/dokumen-bu', 'Dki\PengajuanAnggotaController@dokumenPendukung')->name('registration.dokumen-bu');
        /*
        |--------------------------------------------------------------------------
        | Mendapatkan data invoice role sharing
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/invoice/role-sharing', 'Dki\InvoiceRoleSharingController@index')->name('invoice.role-sharing');
        /*
        |--------------------------------------------------------------------------
        | Mendapatkan detail data invoice role sharing
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/invoice/role-sharing-detail', 'Dki\InvoiceRoleSharingController@detailInvoiceRoleSharing')->name('invoice.role-sharing-detail');
        /*
        |--------------------------------------------------------------------------
        | Mengirimkan konfirmasi pembayaran role sharing ke DPN
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/invoice/role-sharing-confirmation', 'Dki\InvoiceRoleSharingController@roleSharingConfirmation')->name('invoice.role-sharing-confirmation');
        
        
        /*
        |--------------------------------------------------------------------------
        | Mendapatkan status pengajuan anggota
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/status/track/{id_detail_kta}', 'Dki\StatusPengajuanController@index')->name('status.tracking');

        /*
        |--------------------------------------------------------------------------
        | Menampilkan anggota yang ingin mendownload KTA & KIA
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/download/list-anggota', 'Dki\KartuTandaAnggotaController@index')->name('download.list-anggota');

        /*
        |--------------------------------------------------------------------------
        | Menampilkan data administrator DPP
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/administrator/list-data', 'Dki\AdministratorController@index')->name('administrator.list-data');

        /*
        |--------------------------------------------------------------------------
        | Menampilkan data administrator DPP
        |--------------------------------------------------------------------------
        |
        */
        Route::patch('/administrator', 'Dki\AdministratorController@updateDataPengurus')->name('administrator.update-data');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan mendapatkan data Administrasi BU
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/perpanjangan/administrasi-bu', 'Dki\PerpanjanganAnggotaController@administrasiBadanUsaha')->name('perpanjangan.get.administrasi-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan mendapatkan data Penanggung Jawab BU
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/perpanjangan/penanggung-jawab-bu', 'Dki\PerpanjanganAnggotaController@penanggungJawabBadanUsaha')->name('perpanjangan.get.pj-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan mendapatkan data Legalitas BU
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/perpanjangan/legalitas-bu', 'Dki\PerpanjanganAnggotaController@formLegalitasBadanUsaha')->name('perpanjangan.get.legalitas-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan mendapatkan data Dokumen BU
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/perpanjangan/dokumen-bu', 'Dki\PerpanjanganAnggotaController@formDokumenPendukung')->name('perpanjangan.get.dokumen-bu');


        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan proses data administrasi BU
        |--------------------------------------------------------------------------
        |
        */
        Route::patch('/perpanjangan/administrasi-bu', 'Dki\PerpanjanganAnggotaProsesController@administrasiBadanUsaha')->name('perpanjangan.post.administrasi-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan proses data administrasi BU
        |--------------------------------------------------------------------------
        |
        */
        Route::patch('/perpanjangan/penanggung-jawab-bu', 'Dki\PerpanjanganAnggotaProsesController@penanggungJawabBadanUsaha')->name('perpanjangan.post.pj-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan proses data legalitas BU
        |--------------------------------------------------------------------------
        |
        */
        Route::patch('/perpanjangan/legalitas-bu', 'Dki\PerpanjanganAnggotaProsesController@legalitasBadanUsaha')->name('perpanjangan.post.legalitas-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan perpanjangan proses data dokumen BU
        |--------------------------------------------------------------------------
        |
        */
        Route::patch('/perpanjangan/dokumen-bu', 'Dki\PerpanjanganAnggotaProsesController@dokumenPendukung')->name('perpanjangan.post.dokumen-bu');

        /*
        |--------------------------------------------------------------------------
        | Pengajuan pemberhentian anggota submit
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/pemberhentian', 'Dki\PemberhentianAnggotaController@berhentiMenjadiAnggota')->name('pemberhentian.post-pemberhentian');

    }); 
    });

    
    


});