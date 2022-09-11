<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    // Route::get('/', function () {
    //     return [
    //         'app' => 'KTA ONLINE INKINDO SEERVICE API',
    //         'version' => '1.0.0',
    //     ];
    // });  


/*
|--------------------------------------------------------------------------
| API Routes For Authentication Members
|--------------------------------------------------------------------------
|
*/

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    
    ], function ($router) {
    
        Route::post('login', 'Api\Anggota\Auth\AuthController@login');
        Route::post('logout', 'Api\Anggota\Auth\AuthController@logout');
        Route::post('refresh', 'Api\Anggota\Auth\AuthController@refresh');
        Route::post('reset', 'Api\Anggota\Auth\AuthController@reset');
        Route::post('me', 'Api\Anggota\Auth\AuthController@me');
        Route::post('register', 'Api\Anggota\Auth\AuthController@register');
    
    });


/*
|--------------------------------------------------------------------------
| API Routes For Frontend
|--------------------------------------------------------------------------
|
*/

Route::get('sponsorships', 'Api\Anggota\Frontend\MainFrontendController@sponsorShips');
Route::get('testimonials', 'Api\Anggota\Frontend\MainFrontendController@testimonials');
Route::get('faqs', 'Api\Anggota\Frontend\MainFrontendController@faqs');
Route::get('all-councils', 'Api\Anggota\Frontend\MainFrontendController@allProvinceOfCouncil');
Route::post('cek-keabsahan', 'Api\Anggota\Frontend\MainFrontendController@checkMembersValidity');
Route::get('berita-inkindo', 'Api\Anggota\Frontend\MainFrontendController@getAllNews');
Route::get('berita-inkindo/detail/{id_news}', 'Api\Anggota\Frontend\MainFrontendController@getDetailNews');


Route::group(['middleware' => 'jwt'], function () {
         
        /*
        |--------------------------------------------------------------------------
        | API Routes For Dashboard
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/dashboard', 'Api\Anggota\Dashboard\DashboardController@getDataAnggota');


        /*
        |--------------------------------------------------------------------------
        | API Routes For new Members Registration
        |--------------------------------------------------------------------------
        |
        */
        Route::get('anggota/members-registration/get-council', 'Api\Anggota\Registration\RegistrationController@getCouncil');
        Route::post('anggota/members-registration/general-member-info', 'Api\Anggota\Registration\RegistrationController@infoUmumBadanUsaha');
        Route::post('anggota/members-registration/administration-bu-1', 'Api\Anggota\Registration\RegistrationController@administrasiBadanUsaha')->name('api.registration.administration-bu');
        Route::post('anggota/members-registration/pjbu-2', 'Api\Anggota\Registration\RegistrationController@penanggungJawabBadanUsaha')->name('api.registration.pjbu');
        Route::post('anggota/members-registration/legality-bu-3', 'Api\Anggota\Registration\RegistrationController@legalitasBadanUsaha')->name('api.registration.legality');
        Route::post('anggota/members-registration/documents-support-bu-4', 'Api\Anggota\Registration\RegistrationController@dokumenPendukung')->name('api.registration.documents');


        /*
        |--------------------------------------------------------------------------
        | API Routes For  Members Re-Registration
        |--------------------------------------------------------------------------
        |
        */
        Route::post('anggota/members-re-registration/general-member-info', 'Api\Anggota\ReRegistration\ReRegistrationController@infoUmumBadanUsaha');
        Route::post('anggota/members-re-registration/administration-bu-1', 'Api\Anggota\ReRegistration\ReRegistrationController@administrasiBadanUsaha')->name('api.re-registration.administration-bu');
        Route::post('anggota/members-re-registration/pjbu-2', 'Api\Anggota\ReRegistration\ReRegistrationController@penanggungJawabBadanUsaha')->name('api.re-registration.pjbu');
        Route::post('anggota/members-re-registration/legality-bu-3', 'Api\Anggota\ReRegistration\ReRegistrationController@legalitasBadanUsaha')->name('api.re-registration.legality');
        Route::post('anggota/members-re-registration/documents-support-bu-4', 'Api\Anggota\ReRegistration\ReRegistrationController@dokumenPendukung')->name('api.re-registration.documents');



        /*
        |--------------------------------------------------------------------------
        | API Routes For Members Status
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/status/get-status-member/{id_registrasi_user}', 'Api\Anggota\Status\StatusKtaController@index')->name('api.status.get-status-member');
        Route::get('anggota/status/get-tracking-member/{id_detail_kta}', 'Api\Anggota\Status\StatusKtaController@getTrackingAnggota')->name('api.status.get-tracking-member');


        /*
        |--------------------------------------------------------------------------
        | API Routes For Members Invoice
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/invoice/get-invoice-member/{id_detail_kta}', 'Api\Anggota\Invoice\InvoiceController@index')->name('api.invoice.get-invoice-member');
        Route::get('anggota/invoice/download-invoice-member/{noInvoice}/{idDetailKta}', 'Api\Anggota\Invoice\InvoiceController@downloadInvoice')->name('api.invoice.download-invoice-member');
    

         /*
        |--------------------------------------------------------------------------
        | API Routes For Members Confirmation Payment
        |--------------------------------------------------------------------------
        |
        */

        Route::post('anggota/payment/confirmation-payment', 'Api\Anggota\Payment\PaymentController@confirmationPayment')->name('api.payment.confirmation-payment');


         /*
        |--------------------------------------------------------------------------
        | API Routes For Members Download KTA
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/kta/data-member/{id_registrasi_user}', 'Api\Anggota\Kta\KtaController@index')->name('api.kta.data-member');
        Route::get('anggota/kta/kta/download-kta-member/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Kta\KtaController@DownloadProcess')->name('api.kta.download-kta-member');
        Route::get('anggota/kta/download-prove-of-registration-member/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Kta\KtaController@downloadBuktiRegistrasiBaru')->name('api.kta.download-prove-registration-member');
        Route::get('anggota/kta/idcard/download-idcard-member/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Kta\KtaController@DownloadProcess')->name('api.kta.download-idcard-member');
        

          /*
        |--------------------------------------------------------------------------
        | API Routes For Members Berangkas (Safe Deposit)
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/documents/{id_registrasi_user}', 'Api\Anggota\Berangkas\BerangkasController@index')->name('api.berangkas.all-documents');
       

        
        /*
        |--------------------------------------------------------------------------
        | API Routes For Extend KTA
        |--------------------------------------------------------------------------
        |
        */

                
                        /*
                        |--------------------------------------------------------------------------
                        | API Routes For Members API Routes For Extend KTA (With-change)
                        |--------------------------------------------------------------------------
                        |
                        */

                        Route::get('anggota/extend-kta-form/edit/administration-bu-1/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Extend\WithUpdate\FormExtendWithUpdateController@formAdminstrasiBadanUsaha')->name('api.extend.form-administration-bu');
                        Route::get('anggota/extend-kta-form/edit/pjbu-2/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Extend\WithUpdate\FormExtendWithUpdateController@formPenanggungJawabBadanUsaha')->name('api.extend.form-pjbu');
                        Route::get('anggota/extend-kta-form/edit/legality-bu-3/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Extend\WithUpdate\FormExtendWithUpdateController@formLegalitasBadanUsaha')->name('api.extend.form-legality');
                        Route::get('anggota/extend-kta-form/edit/documents-support-bu-4/{id_kta}/{id_registrasi_user}', 'Api\Anggota\Extend\WithUpdate\FormExtendWithUpdateController@formDokumenPendukung')->name('api.extend.form-documents');
                

                        Route::put('anggota/extend-kta-process/edit/administration-bu-1', 'Api\Anggota\Extend\WithUpdate\ExtendWithUpdateProcessController@administrasiBadanUsaha')->name('api.extend.process-administration-bu');
                        Route::put('anggota/extend-kta-process/edit/pjbu-2', 'Api\Anggota\Extend\WithUpdate\ExtendWithUpdateProcessController@penanggungJawabBadanUsaha')->name('api.extend.process-pjbu');
                        Route::put('anggota/extend-kta-process/edit/legality-bu-3', 'Api\Anggota\Extend\WithUpdate\ExtendWithUpdateProcessController@legalitasBadanUsaha')->name('api.extend.process-legality');
                        Route::put('anggota/extend-kta-process/edit/documents-support-bu-4', 'Api\Anggota\Extend\WithUpdate\ExtendWithUpdateProcessController@dokumenPendukung')->name('api.extend.process-documents');
                  
                        /*
                        |--------------------------------------------------------------------------
                        | API Routes For Members API Routes For Extend KTA (None-change)
                        |--------------------------------------------------------------------------
                        |
                        */
                        Route::post('anggota/extend-kta-process/non-edit', 'Api\Anggota\Extend\NonUpdate\ExtendNonUpdateProcessController@extendPeriodWithNoUpdate')->name('api.extend.extend-periode');
                  
        /*
        |--------------------------------------------------------------------------
        | API Routes For STOP Membership
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/stop-kta-form/{id_detail_kta}', 'Api\Anggota\Stop\StopKtaController@index')->name('api.stop.form-stop-kta');
        Route::post('anggota/stop-kta-process', 'Api\Anggota\Stop\StopKtaController@stopBeingMember')->name('api.stop.stop-kta-process');
                  
        /*
        |--------------------------------------------------------------------------
        | API Routes For STOP Membership
        |--------------------------------------------------------------------------
        |
        */

        Route::get('anggota/profile/{id_registrasi_user}', 'Api\Anggota\Profile\ProfileController@index')->name('api.profile.profile');

        Route::post('anggota/change-profile/{id_registrasi_user}', 'Api\Anggota\Profile\ProfileController@uploadProfilePicture')->name('api.profile.change-profile');
});

});


/*
    |--------------------------------------------------------------------------
    | API DKI (KHUSUS -_-) v1
    |--------------------------------------------------------------------------
    |
*/

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'DKI'], function () {
        /*
        |--------------------------------------------------------------------------
        | Sign In DPP DKI
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/signin', 'Api\Dki\Auth\AuthController@signin')->name('api.dki.signin');
    });
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/cek-keabsahan', 'Api\Anggota\Keabsahan\KeabsahanController@checkToValidityMember');    
});




