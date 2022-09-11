<?php

/*
|--------------------------------------------------------------------------
| Web Routes Frontend
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'Frontend\MainFrontendController@index')->name('front.home');

Route::get('/alur-proses', 'Frontend\MainFrontendController@alur')->name('front.alur');

Route::get('/frequently-asked-question', 'Frontend\MainFrontendController@faq')->name('front.faq');

Route::get('/layanan-informasi', 'Frontend\MainFrontendController@informasi')->name('front.informasi');

Route::post('/cek-keabsahan-kta', 'Frontend\CekKeAbsahanController@checkToValidityMember')->name('frontend.member.validity');

Route::get('/detail-member-inkindo', 'Frontend\MainFrontendController@detailListMember')->name('frontend.informasi.detail-member');

Route::get('/mebers-berdasarkan-provinsi', 'Frontend\MainFrontendController@allMembersByProvince')->name('frontend.informasi.members-by-province');

Route::get('/detail-pengurus-inkindo', 'Frontend\MainFrontendController@detailPengurus')->name('frontend.informasi.detail-pengurus');

Route::get('/detail-blog/{slug}', 'Frontend\MainFrontendController@blogDetail')->name('frontend.blog.detail-blog');

Route::post('/post-comment', 'Frontend\MainFrontendController@commentAdd')->name('frontend.blog.add-comment');


/*
|--------------------------------------------------------------------------
| Web Routes User Authentication
|--------------------------------------------------------------------------
|
*/

Route::get('login-anggota', 'Backend\Authentication\Anggota\RegistrationUsersController@index')->name('auth.user.show-login');
Route::get('registration-anggota', 'Backend\Authentication\Anggota\RegistrationUsersController@registrationPage')->name('auth.user.show-registration');
Route::get('reset-password-anggota', 'Backend\Authentication\Anggota\RegistrationUsersController@forgotPasswordPage')->name('auth.user.show-forgot-password');

Route::post('/register', 'Backend\Authentication\Anggota\RegistrationUsersController@store')->name('auth.user.regist');
Route::get('/user/verify/{id}', 'Backend\Authentication\Anggota\RegistrationUsersController@update')->name('auth.user.verify');
Route::post('/user/login', 'Backend\Authentication\Anggota\RegistrationUsersController@login')->name('auth.user.login');
Route::post('/user/logout', 'Backend\Authentication\Anggota\RegistrationUsersController@destroy')->name('auth.user.logout');
Route::post('/user/reset/send', 'Backend\Authentication\Anggota\RegistrationUsersController@sendResetPasswordMail')->name('auth.user.send-reset');
Route::get('/user/reset/{remember_token}', 'Backend\Authentication\Anggota\RegistrationUsersController@formResetPassword')->name('auth.user.form-reset');
Route::post('/user/reset/{remember_token}', 'Backend\Authentication\Anggota\RegistrationUsersController@reset')->name('auth.user.reset');



/*
|--------------------------------------------------------------------------
| Web Routes DPP/DPN/ADMIN Authentication
|--------------------------------------------------------------------------
|
*/

// DPP Auth
Route::get('dpp/auth/signin', 'Backend\Authentication\Dewan\DppAuthController@index')->name('dpp.auth');
Route::post('dpp/authenticating', 'Backend\Authentication\Dewan\DppAuthController@store')->name('dpp.auth.login');
Route::post('dpp/signout', 'Backend\Authentication\Dewan\DppAuthController@destroy')->name('dpp.auth.logout');
// End DPP Auth

// DPN Auth
Route::get('dpn/auth/signin', 'Backend\Authentication\Dewan\DpnAuthController@index')->name('dpn.auth');
Route::post('dpn/authenticating', 'Backend\Authentication\Dewan\DpnAuthController@store')->name('dpn.auth.login');
Route::post('dpn/signout', 'Backend\Authentication\Dewan\DpnAuthController@destroy')->name('dpn.auth.logout');

// Admin Auth
Route::get('super-admin/auth/signin', 'Administrator\Auth\SuperAdministratorAuthController@index')->name('admin.auth');
Route::post('super-admin/authenticating', 'Administrator\Auth\SuperAdministratorAuthController@login')->name('admin.auth.login');
Route::post('super-admin/signout', 'Administrator\Auth\SuperAdministratorAuthController@destroy')->name('admin.auth.logout');



/*
|--------------------------------------------------------------------------
| Web Routes User Anggota
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => '/panel/anggota', 'middleware' => ['prevent_user']], function () {
        
        // Dashboard
    Route::get('dashboard-anggota', 'Backend\Anggota\DashboardController@index')->name('anggota.dashboard');
    // End Of Dashboard Route

    // Profile
    Route::get('profile-badan-usaha', 'Backend\Anggota\ProfileController@index')->name('anggota.profile');
    Route::post('profile-badan-usaha/upload', 'Backend\Anggota\ProfileController@uploadProfilePicture')->name('anggota.profile.upload');
    Route::post('profile-badan-usaha/reset-password', 'Backend\Anggota\ProfileController@resetPassword')->name('anggota.profile.reset-pwd');
    // End Of profile

    // Registration
    Route::get('registrasi-anggota', 'Backend\Anggota\RegistrationController@index')->name('anggota.registration');
    Route::get('1', 'Backend\Anggota\RegistrationController@formAdminstrasiBadanUsaha')->name('anggota.registration.formAdministrasiBadanUsaha');
    Route::get('2', 'Backend\Anggota\RegistrationController@formPenanggungJawabBadanUsaha')->name('anggota.registration.formPenanggungJawabBadanUsaha');
    Route::get('3', 'Backend\Anggota\RegistrationController@formLegalitasBadanUsaha')->name('anggota.registration.formLegalitasBadanUsaha');
    Route::get('4', 'Backend\Anggota\RegistrationController@formDokumenPendukung')->name('anggota.registration.formUploadDokumenPendukung');
       
       
    Route::post('registrasi-anggota/info-umum-bu', 'Backend\Anggota\ProcessRegistrationController@infoUmumBadanUsaha')->name('anggota.registration.infoUmumBadanUsaha');
    Route::post('registrasi-anggota/administrasi-bu', 'Backend\Anggota\ProcessRegistrationController@administrasiBadanUsaha')->name('anggota.registration.administrasiBadanUsaha');
    Route::post('registrasi-anggota/penanggung-jawab-bu', 'Backend\Anggota\ProcessRegistrationController@penanggungJawabBadanUsaha')->name('anggota.registration.penanggungJawabBadanUsaha');
    Route::post('registrasi-anggota/legalitas-bu', 'Backend\Anggota\ProcessRegistrationController@legalitasBadanUsaha')->name('anggota.registration.legalitasBadanUsaha');
    Route::post('registrasi-anggota/dokumen-pendukung', 'Backend\Anggota\ProcessRegistrationController@dokumenPendukung')->name('anggota.registration.dokumen');
    // End Of Registration Route


    // Re-Registration
    Route::get('pendaftaran-ulang', 'Backend\Anggota\ReRegistrationController@index')->name('anggota.re-registration');
    Route::get('pendaftaran-ulang/1', 'Backend\Anggota\ReRegistrationController@formAdminstrasiBadanUsaha')->name('anggota.re-registration.formAdministrasiBadanUsaha');
    Route::get('pendaftaran-ulang/2', 'Backend\Anggota\ReRegistrationController@formPenanggungJawabBadanUsaha')->name('anggota.re-registration.formPenanggungJawabBadanUsaha');
    Route::get('pendaftaran-ulang/3', 'Backend\Anggota\ReRegistrationController@formLegalitasBadanUsaha')->name('anggota.re-registration.formLegalitasBadanUsaha');
    Route::get('pendaftaran-ulang/4', 'Backend\Anggota\ReRegistrationController@formDokumenPendukung')->name('anggota.re-registration.formUploadDokumenPendukung');
        
        
    Route::post('pendaftaran-ulang/info-umum-bu', 'Backend\Anggota\ProcessReRegistrtionController@infoUmumBadanUsaha')->name('anggota.re-registration.infoUmumBadanUsaha');
    Route::post('pendaftaran-ulang/administrasi-bu', 'Backend\Anggota\ProcessReRegistrtionController@administrasiBadanUsaha')->name('anggota.re-registration.administrasiBadanUsaha');
    Route::post('pendaftaran-ulang/penanggung-jawab-bu', 'Backend\Anggota\ProcessReRegistrtionController@penanggungJawabBadanUsaha')->name('anggota.re-registration.penanggungJawabBadanUsaha');
    Route::post('pendaftaran-ulang/legalitas-bu', 'Backend\Anggota\ProcessReRegistrtionController@legalitasBadanUsaha')->name('anggota.re-registration.legalitasBadanUsaha');
    Route::post('pendaftaran-ulang/dokumen-pendukung', 'Backend\Anggota\ProcessReRegistrtionController@dokumenPendukung')->name('anggota.re-registration.dokumen');
    // End Of Re-Registration Route
 

    // Status
    Route::get('status-anggota', 'Backend\Anggota\StatusKtaController@index')->name('anggota.status.main');
    Route::get('get-tracking-anggota/{id}', 'Backend\Anggota\StatusKtaController@getTrackingAnggota');
    // End of Status Route



    //Extend KTA
    // Extend KTA with No Update Route
    Route::get('form-perpanjangan-kta/{id_detail_kta}', 'Backend\Anggota\ExtendKtaController@index')->name('anggota.extend');
    Route::post('perpanjang-kta', 'Backend\Anggota\ExtendKtaController@extendPeriodWithNoUpdate')->name('anggota.extend.period');
    // End Extend KTA with No Update

    // Extend KTA with Update Route
    Route::get('form-perpanjangan-kta/edit/1/{id}', 'Backend\Anggota\FormUpdateAndExtendController@formAdminstrasiBadanUsaha')->name('anggota.update.formAdministrasiBadanUsaha');
    Route::get('form-perpanjangan-kta/edit/2/{id}', 'Backend\Anggota\FormUpdateAndExtendController@formPenanggungJawabBadanUsaha')->name('anggota.update.formPenanggungJawabBadanUsaha');
    Route::get('form-perpanjangan-kta/edit/3/{id}', 'Backend\Anggota\FormUpdateAndExtendController@formLegalitasBadanUsaha')->name('anggota.update.formLegalitasBadanUsaha');
    Route::get('form-perpanjangan-kta/edit/4/{id}', 'Backend\Anggota\FormUpdateAndExtendController@formDokumenPendukung')->name('anggota.update.formUploadDokumenPendukung');
            
    Route::post('extend-update-anggota/info-umum-bu', 'Backend\Anggota\ProcessUpdateAndExtendController@infoUmumBadanUsaha')->name('anggota.update.infoUmumBadanUsaha');
    Route::post('extend-update-anggota/administrasi-bu', 'Backend\Anggota\ProcessUpdateAndExtendController@administrasiBadanUsaha')->name('anggota.update.administrasiBadanUsaha');
    Route::post('extend-update-anggota/penanggung-jawab-bu', 'Backend\Anggota\ProcessUpdateAndExtendController@penanggungJawabBadanUsaha')->name('anggota.update.penanggungJawabBadanUsaha');
    Route::post('extend-update-anggota/legalitas-bu', 'Backend\Anggota\ProcessUpdateAndExtendController@legalitasBadanUsaha')->name('anggota.update.legalitasBadanUsaha');
    Route::post('extend-update-anggota/dokumen-pendukung', 'Backend\Anggota\ProcessUpdateAndExtendController@dokumenPendukung')->name('anggota.update.dokumen');
    // Extend KTA with Update Route
    //End of Extend KTA Route

    // Stop KTA
    Route::get('form-pemberhentian-kta/{id}', 'Backend\Anggota\StopKtaController@index')->name('anggota.stop');
    Route::post('pemberhentian-kta', 'Backend\Anggota\StopKtaController@stopBeingMember')->name('anggota.stop.membership');
    //End of Stop KTA Route


    // Download KTA Route
    Route::get('download-kta-page', 'Backend\Anggota\DownloadKtaController@index')->name('anggota.download-kta');
    Route::get('download/kta/{idKta}', 'Backend\Anggota\DownloadKtaController@DownloadProcess')->name('anggota.process-download-kta');
    Route::get('download/idcard/{idKta}', 'Backend\Anggota\DownloadKtaController@DownloadProcess')->name('anggota.process-download-idcard');
    Route::get('download-bukti-registrasi-baru/{idKta}', 'Backend\Anggota\DownloadKtaController@downloadBuktiRegistrasiBaru')->name('anggota.process-download-bukti-registrasi');    
    // End Of Download KTA Route

    //Berangakas Anggota Route
    Route::get('berangkas-anggota', 'Backend\Anggota\BerangkasController@index')->name('anggota.berangkas.main');
    Route::get('berangkas-anggota/download/{file_name}', 'Backend\Anggota\BerangkasController@downloadFileDocument')->name('anggota.berangkas.download');
    Route::get('berangakas-anggota/file-detail/{file_name}', 'Backend\Anggota\BerangkasController@fileDetail')->name('anggota.berangkas.detail');
    // End Of Berangkas Anggota Route
        
    // Invoice Anggota Route
    Route::get('invoice-anggota', 'Backend\Anggota\InvoiceController@index')->name('anggota.invoice.main');
    Route::get('get-invoice-anggota', 'Backend\Anggota\InvoiceController@getAnggotaInvoice')->name('anggota.invoice.get-data');
    Route::get('detail-invoice-anggota/{no_invoice}/{id_detail_kta}', 'Backend\Anggota\InvoiceController@showInvoiceDetail')->name('anggota.invoice.detail');
    Route::get('download-invoice-anggota/{no_invoice}/{id_detail_kta}', 'Backend\Anggota\InvoiceController@downloadInvoice')->name('anggota.invoice.download');
    
    // End of Invoice Anggota Route

    // Payment Confirmation Route
    Route::post('check-invoice-anggota', 'Backend\Anggota\PaymentConfirmationController@checkNoInvoiceAnggota')->name('anggota.payment.getinvoice');
    Route::post('save-invoice-anggota', 'Backend\Anggota\PaymentConfirmationController@saveConfirmationPayment')->name('anggota.payment.save');
        
    // End of

    //Notification route
    Route::post('anggota-notification', 'Backend\Anggota\AnggotaNotifyController@index')->name('anggota.notification.read');
});


/*
|--------------------------------------------------------------------------
| Web Routes  User DPP
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => '/panel/dpp', 'middleware' => ['prevent_council']], function () {
    Route::get('dashboard-dpp', 'Backend\Dpp\Dashboard\DashboardDppController@index')->name('dpp.dashboard');

    Route::group(['prefix' => 'master-anggota'], function () {
        // Screening Dokumen Anggota
        Route::get('anggota-baru', 'Backend\Dpp\MasterAnggota\MasterAnggotaController@anggotaBaru')->name('dpp.master-anggota.baru');
        Route::get('get-anggota-baru', 'Backend\Dpp\MasterAnggota\MasterAnggotaController@getDataAnggotaBaru')->name('dpp.mastertables.baru');

        Route::get('anggota-berhenti', 'Backend\Dpp\MasterAnggota\MasterAnggotaController@anggotaBerhenti')->name('dpp.master-anggota.berhenti');
        Route::get('get-anggota-berhenti', 'Backend\Dpp\MasterAnggota\MasterAnggotaController@getDataAnggotaBerhenti')->name('dpp.mastertables.berhenti');
           
        Route::get('screen/document/anggota/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ScreeningDocumentController@showDocumentAnggotaBaru')->name('dpp.master-anggota.screening') ;
        Route::get('screen/document/anggota/download/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ScreeningDocumentController@downloadFileDocument')->name('dpp.master-anggota.download');
     
        Route::get('screen/document/anggota/berhenti/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ScreeningDocumentController@showDocumenPemberhentiantAnggota')->name('dpp.pemberhentian.screening') ;
        Route::get('screen/document/anggota/download/berhenti/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ScreeningDocumentController@downloadFileDocumentPemberhentian')->name('dpp.pemberhentian.download');
           
        // Approval Dokumen Anggota baru
        Route::get('anggota-baru/dokumen/approve/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ApprovalAnggotaDokumenController@approveDokumenBuatBaru')->name('dpp.master-anggota.approve');
        Route::post('anggota-baru/dokumen/reject', 'Backend\Dpp\MasterAnggota\ApprovalAnggotaDokumenController@rejectDokumenBuatBaru')->name('dpp.master-anggota.reject');
        // Approval Dokumen Anggota baru
        Route::get('pemberhentian/dokumen/approve/{id_detail_kta}', 'Backend\Dpp\MasterAnggota\ApprovalAnggotaDokumenController@approveDokumenPemberhentian')->name('dpp.pemberhentian.approve');
        Route::post('pemberhentian/dokumen/reject', 'Backend\Dpp\MasterAnggota\ApprovalAnggotaDokumenController@rejectDokumenPemberhentian')->name('dpp.pemberhentian.reject');
   
        Route::get('edit/data/{id_detail_kta}', 'Backend\Dpp\Edit\DataAnggotaController@editAnggota')->name('dpp.edit.documents');
        Route::post('update-administrasi-bu-lokal-afiliasi', 'Backend\Dpp\Edit\DataAnggotaController@updateAdministrasiAnggota')->name('dpp.edit.update-administrasi-bu-lokal');
        Route::post('update-penanggung-jawab-bu-lokal-afiliasi', 'Backend\Dpp\Edit\DataAnggotaController@penanggungJawabBadanUsaha')->name('dpp.edit.update-penanggung-jawab-bu-lokal');
        Route::post('update-legalitas-bu-lokal-afiliasi', 'Backend\Dpp\Edit\DataAnggotaController@legalitasBadanUsaha')->name('dpp.edit.update-legaliats-bu-lokal');
        Route::post('update-dokumen-bu-lokal-afiliasi', 'Backend\Dpp\Edit\DataAnggotaController@dokumenPendukung')->name('dpp.edit.update-dokumen-bu-lokal');
        Route::post('update-akun-lokal-afiliasi', 'Backend\Dpp\Edit\DataAnggotaController@accountAnggota')->name('dpp.edit.update-akun-bu-lokal');
 
    });


    Route::group(['prefix' => 'invoice'], function () {
        Route::get('invoice-anggota', 'Backend\Dpp\Invoice\InvoiceAnggotaController@index')->name('dpp.invoice.anggota');
        Route::get('get-invoice-anggota', 'Backend\Dpp\Invoice\InvoiceAnggotaController@getInvoiceAnggota')->name('dpp.invoice.get-anggota');
        Route::post('publish-invoice-anggota', 'Backend\Dpp\Invoice\InvoiceAnggotaController@publishInvoiceAnggota')->name('dpp.invoice.publish-anggota');
        Route::get('invoice-anggota-published', 'Backend\Dpp\Invoice\InvoiceAnggotaController@getInvoiceAnggotaPublished')->name('dpp.invoice.get-publish-anggota');
        Route::get('invoice-anggota-showing/{no_invoice}/{id_detail_kta}', 'Backend\Dpp\Invoice\InvoiceAnggotaController@showInvoice')->name('dpp.invoice.show');
        Route::get('invoice-anggota-download/{no_invoice}/{id_detail_kta}', 'Backend\Dpp\Invoice\InvoiceAnggotaController@downloadInvoice')->name('dpp.invoice.download');
        Route::get('invoice-role-share', 'Backend\Dpp\Invoice\InvoiceAnggotaController@invoiceRoleShare')->name('dpp.invoice.roleshare');
        Route::get('get-invoice-role-share', 'Backend\Dpp\Invoice\InvoiceAnggotaController@getInvoiceRoleShare')->name('dpp.invoice.get-roleshare');
        Route::get('invoice-role-share-showing/{no_invoice}/{id_detail_kta}', 'Backend\Dpp\Invoice\InvoiceAnggotaController@showInvoiceRoleShare')->name('dpp.invoice.roleshare-show');
        Route::post('save-confirmation-role-share', 'Backend\Dpp\Invoice\InvoiceAnggotaController@saveRoleShareConfirmation')->name('dpp.invoice.roleshare-save');
        
    });

    Route::group(['prefix' => 'pembayaran'], function () {
        Route::get('pembayaran-anggota', 'Backend\Dpp\Payment\PaymentAnggotaController@index')->name('dpp.payment.main');
        Route::get('data-pembayaran-anggota', 'Backend\Dpp\Payment\PaymentAnggotaController@getDataPaymentAnggota')->name('dpp.payment.getdatapayment');
        Route::post('detail-pembayaran-anggota', 'Backend\Dpp\Payment\PaymentAnggotaController@getDetailDataPaymentAnggota')->name('dpp.payment.getdetaildatapayment');
        Route::post('verifikasi-pembayaran', 'Backend\Dpp\Payment\PaymentAnggotaController@acceptPaymentAnggota')->name('dpp.payment.accept');
        Route::get('dpp-verified/{id_detail_kta}', 'Backend\Dpp\Payment\PaymentAnggotaController@dppVerifiyAnggota')->name('dpp.payment.verify');
      
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('dpp-report', 'Backend\Dpp\Report\DppReportController@index')->name('dpp.report.main');
        Route::post('generate-report', 'Backend\Dpp\Report\DppReportController@generateReport')->name('dpp.report.generate');
    });

    Route::group(['prefix' => 'administrator'], function () {
        Route::get('dashboard', 'Backend\Dpp\Administrator\DppAdministratorController@index')->name('dpp.administrator.main');
        Route::post('update-info', 'Backend\Dpp\Administrator\DppAdministratorController@saveDataPengurus')->name('dpp.administrator.update');
        Route::post('reset-password', 'Backend\Dpp\Administrator\DppAdministratorController@resetPasswordDpp')->name('dpp.administrator.reset-password');
    });

    Route::group(['prefix' => 'akses-kta'], function () {
        Route::get('buka-akses-kta-anggota', 'Backend\Dpp\AksesKta\AksesKtaAnggotaController@index')->name('dpp.akses.kta');
        Route::post('get-data-anggota', 'Backend\Dpp\AksesKta\AksesKtaAnggotaController@getDataAnggota')->name('dpp.akses.get-data-anggota');
        Route::post('buka-akses-kta-anggota', 'Backend\Dpp\AksesKta\AksesKtaAnggotaController@enableKtaAccess')->name('dpp.akses.enable');
   
    });

    // Download KTA Route
    Route::get('download-kta-page', 'Backend\Dpp\Download\DownloadKtaController@index')->name('dpp.download-kta');
    Route::get('download/kta/{idKta}', 'Backend\Dpp\Download\DownloadKtaController@DownloadProcess')->name('dpp.process-download-kta');
    Route::get('download/idcard/{idKta}', 'Backend\Dpp\Download\DownloadKtaController@DownloadProcess')->name('dpp.process-download-idcard');
   

});


/*
|--------------------------------------------------------------------------
| Web Routes  User DPN
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => '/panel/dpn', 'middleware' => ['prevent_dpn']], function () {
    Route::get('dashboard-dpn', 'Backend\Dpn\Dashboard\DashboardDpnController@index')->name('dpn.dashboard');

    Route::group(['prefix' => 'master-anggota'], function () {
        // Screening Dokumen Anggota
        Route::get('anggota-baru', 'Backend\Dpn\MasterAnggota\MasterAnggotaController@anggotaBaru')->name('dpn.master-anggota.baru');
        Route::get('get-anggota-baru', 'Backend\Dpn\MasterAnggota\MasterAnggotaController@getDataAnggotaBaru')->name('dpn.mastertables.baru');

        Route::get('anggota-berhenti', 'Backend\Dpn\MasterAnggota\MasterAnggotaController@anggotaBerhenti')->name('dpn.master-anggota.berhenti');
        Route::get('get-anggota-berhenti', 'Backend\Dpn\MasterAnggota\MasterAnggotaController@getDataAnggotaBerhenti')->name('dpn.mastertables.berhenti');
           
        Route::get('screen/document/anggota/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ScreeningDocumentController@showDocumentAnggotaBaru')->name('dpn.master-anggota.screening') ;
        Route::get('screen/document/anggota/download/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ScreeningDocumentController@downloadFileDocument')->name('dpn.master-anggota.download');
     
        Route::get('screen/document/anggota/berhenti/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ScreeningDocumentController@showDocumenPemberhentiantAnggota')->name('dpn.pemberhentian.screening') ;
        Route::get('screen/document/anggota/download/berhenti/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ScreeningDocumentController@downloadFileDocumentPemberhentian')->name('dpn.pemberhentian.download');
           
        // Approval Dokumen Anggota baru
        Route::get('anggota-baru/dokumen/approve/{jenis_bu}/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ApprovalAnggotaDokumenController@approveDokumenBuatBaru')->name('dpn.master-anggota.approve');
        Route::post('anggota-baru/dokumen/reject', 'Backend\Dpn\MasterAnggota\ApprovalAnggotaDokumenController@rejectDokumenBuatBaru')->name('dpn.master-anggota.reject');
        // Approval Dokumen Anggota baru
        Route::get('pemberhentian/dokumen/approve/{id_detail_kta}', 'Backend\Dpn\MasterAnggota\ApprovalAnggotaDokumenController@approveDokumenPemberhentian')->name('dpn.pemberhentian.approve');
        Route::post('pemberhentian/dokumen/reject', 'Backend\Dpn\MasterAnggota\ApprovalAnggotaDokumenController@rejectDokumenPemberhentian')->name('dpn.pemberhentian.reject');
    });

    Route::group(['prefix' => 'invoice'], function () {
        Route::get('invoice-role-share-lokal', 'Backend\Dpn\Invoice\InvoiceDpnController@invoiceRoleSharing')->name('dpn.invoice.roleshare');
        Route::get('get-anggota-lokal', 'Backend\Dpn\Invoice\InvoiceDpnController@getAnggotaLokal')->name('dpn.invoice.get-anggota');
        Route::post('publish-role-share-invoice', 'Backend\Dpn\Invoice\InvoiceDpnController@publishInvoiceRoleShare')->name('dpn.invoice.publish-roleshare-invoice');
        Route::get('invoice-role-share-published', 'Backend\Dpn\Invoice\InvoiceDpnController@getInvoiceAnggotaPublished')->name('dpn.invoice.get-publish-role-share');
        Route::get('invoice-role-share-showing/{no_invoice}/{id_detail_kta}', 'Backend\Dpn\Invoice\InvoiceDpnController@showInvoice')->name('dpn.invoice.show-role-share');
        Route::get('invoice-role-share-download/{no_invoice}/{id_detail_kta}', 'Backend\Dpn\Invoice\InvoiceDpnController@downloadInvoice')->name('dpn.invoice.download-role-share');
    
        Route::get('invoice-afiliasi', 'Backend\Dpn\Invoice\InvoiceDpnController@invoiceAnggotaAfiliasi')->name('dpn.invoice.afiliasi');
        Route::get('get-anggota-afiliasi', 'Backend\Dpn\Invoice\InvoiceDpnController@getAnggotaAfiliasi')->name('dpn.invoice.get-afiliasi');
        Route::post('publish-afiliasi-invoice', 'Backend\Dpn\Invoice\InvoiceDpnController@publishInvoiceAnggotaAfiliasi')->name('dpn.invoice.publish-afiliasi-invoice');
        Route::get('invoice-afiliasi-published', 'Backend\Dpn\Invoice\InvoiceDpnController@getInvoiceAnggotaAfiliasiPublished')->name('dpn.invoice.get-publish-afiliasi');
        Route::get('invoice-afiliasi-showing/{no_invoice}/{id_detail_kta}', 'Backend\Dpn\Invoice\InvoiceDpnController@showInvoiceAfiliasi')->name('dpn.invoice.show-afiliasi');
        Route::get('invoice-afiliasi-download/{no_invoice}/{id_detail_kta}', 'Backend\Dpn\Invoice\InvoiceDpnController@downloadInvoiceAfiliasi')->name('dpn.invoice.download-afiliasi');
    
    });

    Route::group(['prefix' => 'pembayaran'], function () {
        Route::get('pembayaran-anggota-afiliasi', 'Backend\Dpn\Payment\PaymentDpnController@anggotaAfiliasi')->name('dpn.payment.anggota-afiliasi');
        Route::get('get-pembayaran-anggota-afiliasi', 'Backend\Dpn\Payment\PaymentDpnController@getAnggotaAfiliasi')->name('dpn.payment.get-anggota-afiliasi');
        Route::post('detail-pembayaran-afiliasi', 'Backend\Dpn\Payment\PaymentDpnController@getDetailDataPaymentAnggotaAfiliasi')->name('dpn.payment.getdetail-data-payment');
        Route::post('verifikasi-pembayaran-afiliasi', 'Backend\Dpn\Payment\PaymentDpnController@acceptPaymentAnggotaAfiliasi')->name('dpp.payment.accept-afiliasi');
        Route::get('dpn-verified-afiliasi-payment/{id_detail_kta}', 'Backend\Dpn\Payment\PaymentDpnController@verifikasiPembayaranAnggotaAfiliasi')->name('dpn.payment.afiliasi-verify');
       
        Route::get('pembayaran-role-sharing', 'Backend\Dpn\Payment\PaymentDpnController@roleSharingDpp')->name('dpn.payment.role-share');
        Route::get('get-pembayaran-role-sharing', 'Backend\Dpn\Payment\PaymentDpnController@getRoleSharePayment')->name('dpn.payment.get-role-share-payment');
        Route::post('detail-pembayaran-role-share', 'Backend\Dpn\Payment\PaymentDpnController@getDetailDataPaymentRoleShare')->name('dpn.payment.getdetail-role-share-payment');
        Route::post('verifikasi-pembayaran-role-share', 'Backend\Dpn\Payment\PaymentDpnController@acceptPaymentRoleShare')->name('dpn.payment.accept-role-share');
        Route::get('dpn-verified-role-share-payment/{id_detail_kta}', 'Backend\Dpn\Payment\PaymentDpnController@verifikasiPembayaranAnggotaAfiliasi')->name('dpn.payment.role-share-verify');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('dpn-report', 'Backend\Dpn\Report\DpnReportController@index')->name('dpn.report.main');
        Route::post('generate-report-dpn', 'Backend\Dpn\Report\DpnReportController@generateReport')->name('dpn.report.generate');
    });

    Route::group(['prefix' => 'administrator'], function () {
        Route::get('dashboard', 'Backend\Dpn\Administrator\DpnAdministratorController@index')->name('dpn.administrator.main');
        Route::post('update-info', 'Backend\Dpn\Administrator\DpnAdministratorController@saveDataPengurus')->name('dpn.administrator.update');
        Route::post('reset-password', 'Backend\Dpn\Administrator\DpnAdministratorController@resetPasswordDpp')->name('dpn.administrator.reset-password');
    });
    
    Route::group(['prefix' => 'publish-kta/daftar-ulang'], function () {
        Route::get('penerbitan-ulang-kta', 'Backend\Dpn\Kta\KtaController@daftarUlangKta')->name('dpn.kta.daftar-ulang');
        Route::get('get-penerbitan-ulang-kta', 'Backend\Dpn\Kta\KtaController@getAnggotaDaftarUlang')->name('dpn.kta.get-daftar-ulang');
        Route::post('publish-penerbitan-ulang-kta', 'Backend\Dpn\Kta\KtaController@publishKtaDaftarUlang')->name('dpn.kta.daftar-ulang-publish');
    
    });

    Route::group(['prefix' => 'publish-kta/afiliasi'], function () {
        Route::get('penerbitan-afiliasi-kta', 'Backend\Dpn\Kta\KtaController@afiliasiKta')->name('dpn.kta.afiliasi-page');
        Route::get('get-anggota-afiliasi-final', 'Backend\Dpn\Kta\KtaController@getAnggotaAfiliasiFinal')->name('dpn.kta.get-afiliasi-kta');  
        Route::post('publish-kta-afiliasi', 'Backend\Dpn\Kta\KtaController@publishKtaAfiliasi')->name('dpn.kta.afiliasi-publish'); 
    });


    Route::group(['prefix' => 'publish-kta/lokal'], function () {
        Route::get('penerbitan-lokal-kta', 'Backend\Dpn\Kta\KtaController@lokalKta')->name('dpn.kta.lokal-page');
        Route::get('get-anggota-lokal-final', 'Backend\Dpn\Kta\KtaController@getAnggotaLokalFinal')->name('dpn.kta.get-lokal-kta');  
        Route::post('publish-kta-lokal', 'Backend\Dpn\Kta\KtaController@publishKtaLokal')->name('dpn.kta.lokal-publish');       
    });

    // Download KTA Route
    Route::get('download-kta-page', 'Backend\Dpn\Download\DownloadKtaController@index')->name('dpn.download-kta');
    Route::get('download/kta/{idKta}', 'Backend\Dpn\Download\DownloadKtaController@DownloadProcess')->name('dpn.process-download-kta');
    Route::get('download/idcard/{idKta}', 'Backend\Dpn\Download\DownloadKtaController@DownloadProcess')->name('dpn.process-download-idcard');
    Route::get('download-kta-get', 'Backend\Dpn\Download\DownloadKtaController@getData')->name('dpn.download-kta.get');
    



    
   
    
});


/*
|--------------------------------------------------------------------------
| Web Routes  User Super Administrator
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => '/inkindo-pusat/administrator', 'middleware' => ['prevent_admin']], function () {
   Route::get('dashboard', 'Administrator\Dashboard\DashboardController@index')->name('administrator.dashboard.main');
   Route::post('dashboard/post', 'Administrator\Dashboard\DashboardController@dashboardAjax')->name('administrator.dashboard.post-ajax');
   Route::post('dashboard/post/byProvince', 'Administrator\Dashboard\DashboardController@dashboardFilterByProvinsiAjax')->name('administrator.dashboard.post-ajax-filter');
   Route::get('dashboard/export-to-excel/', 'Administrator\Dashboard\DashboardController@exportToExcel')->name('administrator.dashboard.export-excel');
   Route::get('dashboard/export-to-pdf/', 'Administrator\Dashboard\DashboardController@exportToPdf')->name('administrator.dashboard.export-pdf');
   
   Route::group(['prefix' => 'master-anggota'], function () {
       Route::get('anggota-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@Index')->name('administrator.masater-anggota.main');
       Route::get('get-anggota-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@getAnggotaLokal')->name('administrator.masater-anggota.get-agt-lokal');
       Route::get('edit-anggota-lokal-afiliasi/{id_detail_kta}', 'Administrator\MasterAnggota\MasterAnggotaController@editAnggota')->name('administrator.master-anggota.edit-anggota-lokal');
       Route::post('update-administrasi-bu-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@updateAdministrasiAnggota')->name('administrator.master-anggota.update-administrasi-bu-lokal');
       Route::post('update-penanggung-jawab-bu-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@penanggungJawabBadanUsaha')->name('administrator.master-anggota.update-penanggung-jawab-bu-lokal');
       Route::post('update-legalitas-bu-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@legalitasBadanUsaha')->name('administrator.master-anggota.update-legaliats-bu-lokal');
       Route::post('update-dokumen-bu-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@dokumenPendukung')->name('administrator.master-anggota.update-dokumen-bu-lokal');
       Route::post('update-akun-lokal-afiliasi', 'Administrator\MasterAnggota\MasterAnggotaController@accountAnggota')->name('administrator.master-anggota.update-akun-bu-lokal');

       Route::post('delete-anggota', 'Administrator\MasterAnggota\MasterAnggotaController@deleteAnggota')->name('administrator.master-anggota.delete-anggota');
  
    });


    Route::group(['prefix' => 'cms'], function () {
        // Testimonials
        Route::get('testimonials', 'Administrator\Cms\FrontendTestimonialsController@testimonials')->name('administrator.cms.frontend-testimonials');
        Route::get('get-testimonials', 'Administrator\Cms\FrontendTestimonialsController@getTestimonials')->name('administrator.cms.frontend-get-testimonials');
        Route::get('form-tambah-testimonials', 'Administrator\Cms\FrontendTestimonialsController@addTestimonials')->name('administrator.cms.frontend-add-testimonials');
        Route::post('tambah-testimonials', 'Administrator\Cms\FrontendTestimonialsController@addTestimonialsProcess')->name('administrator.cms.frontend-add-testimonials-process');
        Route::get('edit-testimonials/{id}', 'Administrator\Cms\FrontendTestimonialsController@editTestimonials')->name('administrator.cms.frontend-edit-testimonials');
        Route::post('update-testimonials/{id}', 'Administrator\Cms\FrontendTestimonialsController@updateTestimonialsProcess')->name('administrator.cms.frontend-update-testimonials');
        Route::get('delete-testimonials/{id}', 'Administrator\Cms\FrontendTestimonialsController@destroy')->name('administrator.cms.frontend-delete-testimonials');
        
        // Sponsorship
        Route::get('sponsorship', 'Administrator\Cms\FrontendSponsorshipController@sponsorship')->name('administrator.cms.frontend-sponsorship');
        Route::resource('warning', 'Administrator\Cms\FrontendWarningController',['except'=>'show','store']);
        Route::get('get-warning', 'Administrator\Cms\FrontendWarningController@get_data')->name('administrator.get-warning');
        Route::get('get-sponsorship', 'Administrator\Cms\FrontendSponsorshipController@getSponsorship')->name('administrator.cms.frontend-get-sponsorship');
        Route::get('form-tambah-sponsorship', 'Administrator\Cms\FrontendSponsorshipController@addSponsorship')->name('administrator.cms.frontend-add-sponsorship');
        Route::post('tambah-sponsorship', 'Administrator\Cms\FrontendSponsorshipController@addSponsorshipProcess')->name('administrator.cms.frontend-add-sponsorship-process');
        Route::get('edit-sponsorship/{id}', 'Administrator\Cms\FrontendSponsorshipController@editSponsorship')->name('administrator.cms.frontend-edit-sponsorship');
        Route::post('update-sponsorship/{id}', 'Administrator\Cms\FrontendSponsorshipController@updateSponsorshipProcess')->name('administrator.cms.frontend-update-sponsorship');
        Route::get('delete-sponsorship/{id}', 'Administrator\Cms\FrontendSponsorshipController@destroy')->name('administrator.cms.frontend-delete-sponsorship');
        
         // Frequently Asked Questions
         Route::get('faq', 'Administrator\Cms\FrontendFaqController@faq')->name('administrator.cms.frontend-faq');
         Route::get('get-faq', 'Administrator\Cms\FrontendFaqController@getFaq')->name('administrator.cms.frontend-get-faq');
         Route::get('form-tambah-faq', 'Administrator\Cms\FrontendFaqController@addFaq')->name('administrator.cms.frontend-add-faq');
         Route::post('tambah-faq', 'Administrator\Cms\FrontendFaqController@addFaqProcess')->name('administrator.cms.frontend-add-faq-process');
         Route::get('edit-faq/{id}', 'Administrator\Cms\FrontendFaqController@editFaq')->name('administrator.cms.frontend-edit-faq');
         Route::post('update-faq/{id}', 'Administrator\Cms\FrontendFaqController@updateFaqProcess')->name('administrator.cms.frontend-update-faq');
         Route::get('delete-faq/{id}', 'Administrator\Cms\FrontendFaqController@destroy')->name('administrator.cms.frontend-delete-faq');
        
         // Portal berita
         Route::get('portal-berita', 'Administrator\Cms\PortalBeritaController@index')->name('administrator.cms.portal-main');
         Route::get('get-portal-berita', 'Administrator\Cms\PortalBeritaController@getNews')->name('administrator.cms.portal-get-data');
         Route::get('form-tambah-berita', 'Administrator\Cms\PortalBeritaController@formAddNews')->name('administrator.cms.form-tambah');          
         Route::post('tambah-berita', 'Administrator\Cms\PortalBeritaController@addNewsProcess')->name('administrator.cms.tambah-berita-process');          
         Route::get('form-edit-berita/{id}', 'Administrator\Cms\PortalBeritaController@formEditNews')->name('administrator.cms.form-edit');          
         Route::post('form-update-berita/{id}', 'Administrator\Cms\PortalBeritaController@formUpdateNewsProcess')->name('administrator.cms.update-berita-process');          
         Route::get('delete-berita/{id}', 'Administrator\Cms\PortalBeritaController@destroy')->name('administrator.cms.delete-news');
       
        });


        Route::group(['prefix' => 'dewan-pengurus'], function () {
            Route::get('nasional-inkindo', 'Administrator\Dewan\DewanPengurusNasionalController@index')->name('administrator.dewan.dpn-main');
            Route::get('manage-akun-dpn', 'Administrator\Dewan\DewanPengurusNasionalController@manageAccountDpn')->name('administrator.dewan.manage-account-dpn');
            Route::get('manage-data-dpn', 'Administrator\Dewan\DewanPengurusNasionalController@manageDataDpn')->name('administrator.dewan.manage-data-dpn');
            Route::post('simpan-data-dpn', 'Administrator\Dewan\DewanPengurusNasionalController@saveDataDpn')->name('administrator.dewan.save-data-dpn');
            Route::post('simpan-akun-dpn', 'Administrator\Dewan\DewanPengurusNasionalController@saveAccountDpn')->name('administrator.dewan.save-akun-dpn');
        
            Route::get('provinsi-inkindo', 'Administrator\Dewan\DewanPengurusProvinsiController@index')->name('administrator.dewan.dpp-main');
            Route::get('manage-data-dpp', 'Administrator\Dewan\DewanPengurusProvinsiController@manageDataDpp')->name('administrator.dewan.manage-data-dpp');
            Route::get('get-pengurus-dpp', 'Administrator\Dewan\DewanPengurusProvinsiController@getCouncilAllProvince')->name('administrator.dewan.get-council-dpp');
            Route::get('form-tambah-data-dpp',  'Administrator\Dewan\DewanPengurusProvinsiController@formaAddDataDpp')->name('administrator.dewan.form-add-data-dpp');
            Route::post('tambah-data-dpp-proses',  'Administrator\Dewan\DewanPengurusProvinsiController@formaAddDataDppProcess')->name('administrator.dewan.save-data-dpp');           
            Route::get('form-manage-data-dpp/{id_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@formManageDataDpp')->name('administrator.dewan.form-manage-data-dpp');
            Route::post('manage-data-dpp-proses/{id_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@formManageDataDppProcess')->name('administrator.dewan.manage-data-dpp-process');
            Route::get('remove-data-dpp/{id_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@removeDataDpp')->name('administrator.dewan.remove-data-dpp');
            Route::get('manage-akun-dpp',  'Administrator\Dewan\DewanPengurusProvinsiController@manageAkunDpp')->name('administrator.dewan.manage-akun-dpp');
            Route::get('get-akun-dpp',  'Administrator\Dewan\DewanPengurusProvinsiController@getCouncilAccountAllProvince')->name('administrator.dewan.get-akun-dpp');
            Route::get('form-tambah-akun-dpp',  'Administrator\Dewan\DewanPengurusProvinsiController@formaAddAccountDpp')->name('administrator.dewan.form-add-akun-dpp');
            Route::post('tambah-akun-dpp-proses',  'Administrator\Dewan\DewanPengurusProvinsiController@formAddAccountDppProcess')->name('administrator.dewan.add-akun-dpp-process');
            Route::get('form-edit-akun-dpp/{id_users_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@formEditAccountDpp')->name('administrator.dewan.form-edit-akun-dpp');
            Route::post('form-update-akun-dpp/{id_users_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@formUpdateAccountDpp')->name('administrator.dewan.update-akun-dpp-process'); 
            Route::get('remove-akun-dpp/{id_users_dp}',  'Administrator\Dewan\DewanPengurusProvinsiController@removeAccountDpp')->name('administrator.dewan.remove-akun-dpp');
           
        });


        Route::group(['prefix' => 'profile'], function () {
            Route::get('super-admin', 'Administrator\Profile\ProfileController@index')->name('administrator.profile.profile-main');
            Route::get('get-data-super-admin', 'Administrator\Profile\ProfileController@getDataSuperAdmin')->name('administrator.profile.get-data-superadmin');  
            Route::get('form-add-super-admin', 'Administrator\Profile\ProfileController@formAddSuperAdmin')->name('administrator.profile.form-add-superadmin');
            Route::post('add-super-admin-proses', 'Administrator\Profile\ProfileController@addSuperAdminProcess')->name('administrator.profile.add-superadmin-process');
            Route::get('form-edit-super-admin/{id}', 'Administrator\Profile\ProfileController@formEditSuperAdmin')->name('administrator.profile.form-edit-superadmin');
            Route::post('update-super-admin/{id}', 'Administrator\Profile\ProfileController@updateSuperAdminProcess')->name('administrator.profile.update-superadmin-process');
            Route::get('delete-super-admin/{id}', 'Administrator\Profile\ProfileController@destroy')->name('administrator.profile.delete-superadmin');
          
        });
     
});


/*
        |--------------------------------------------------------------------------
        | Mendownload Kartu Tanda Anggota (KTA)
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/download/kta', 'Dki\KartuTandaAnggotaController@downloadKartuAnggota')->name('download.kta-anggota');

        /*
        |--------------------------------------------------------------------------
        | Mendownload Kartu Identitas Anggota
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/download/kia', 'Dki\KartuTandaAnggotaController@downloadKartuAnggota')->name('download.kia-anggota');

   

// Notification
Route::post('/notifications/get', 'Notification\NotificationController@get');
Route::post('/notification/read', 'Notification\NotificationController@read');
