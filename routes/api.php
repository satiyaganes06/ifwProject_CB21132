<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Test\test;
use App\Http\Controllers\User\CpDetailsController;
use App\Http\Controllers\User\ClientUserDetailsController;
use App\Http\Controllers\Common\CommonDataController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Job\JobMainController;
use App\Http\Controllers\Booking\BookingMainController;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\Certificate\CertificateController;
use App\Http\Controllers\PaymentSubscribeController;
use App\Http\Controllers\State\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//!! Version 2 with Access Token

Route::group(['prefix' => 'v2/auth'], function(){
    Route::post('/register', [AuthController::class, 'registration']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// John Doe: 63|ksDgiSwEaT21xsTBh4GGMsqRFLcvFgE0vLYAysQx76ed7af1
// Pan Doe: 62|S7NbS7Ef0Fd2yk17Yj7EuJl2MqDE7esUGG3R2hMie742015e

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => 'v2/competent-person'], function(){

        //Test Routes
        Route::get("/test/getData", [test::class, 'testttt']);

        // Auth
        Route::get('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/getUserID', [AuthController::class, 'getUserID']);

        // Manage User
        Route::get("/manage-user/getCpProfileDetailsByID/{id}", [CpDetailsController::class, 'getCpProfileDetailsByID']);
        Route::get("/manage-user/getClientUserProfileDetailByID/{id}/{clientID}", [CpDetailsController::class, 'getClientUserProfileDetailByID']);
        Route::patch("/manage-user/updateCpProfileDetailsByID/{id}", [CpDetailsController::class, 'updateCpProfileDetailsByID']);
        Route::get("/manage-user/getEmailStatusByID/{id}", [CpDetailsController::class, 'getEmailStatusByID']);
        Route::patch("/manage-user/updateEmailStatusByID/{id}", [CpDetailsController::class, 'updateEmailStatusByID']);
        Route::get("/manage-user/getCpFirstTimeStatusByID/{id}", [CpDetailsController::class, 'getCpFirstTimeStatusByID']);
        Route::get("/manage-user/getCompetentPersonTypeList", [CpDetailsController::class, 'getCompententPersonTypeList']);

        // Certificate
        Route::get("/certificate/getCertificatesDetailByID/{id}", [CertificateController::class, 'getCertificatesDetailByID']);
        Route::post("/certificate/addCertificateDetail", [CertificateController::class, 'addCertificateDetail']);
        Route::patch("/certificate/updateCertificateDetail/{id}", [CertificateController::class, 'updateCertificateDetail']);
        Route::delete("/certificate/deleteCertificateDetailByID/{id}/{ccID}", [CertificateController::class, 'deleteCertificateDetailByID']);

        // Service
        Route::get("/service/getServiceMainList", [ServiceController::class, 'getServiceMainList']);
        Route::get("/service/getSubServiceList", [ServiceController::class, 'getSubServiceList']);

        Route::get('/service/getServicesDetailByID/{id}', [ServiceController::class, 'getServicesDetailByID']);
        Route::post('/service/addServiceDetail', [ServiceController::class, 'addServiceDetail']);
        Route::patch('/service/updateServiceDetail/{id}', [ServiceController::class, 'updateServiceDetail']);
        Route::delete('/service/deleteServiceDetails/{id}/{cpsID}', [ServiceController::class, 'deleteServiceDetails']);

        // State
        Route::get("/state/getStateList", [StateController::class, 'getStateList']);

        // Booking
        Route::get('/booking/getBookingsDetailByID/{id}', [BookingMainController::class, 'getBookingsDetailByID']);
        Route::get('/booking/getBookingRequestDetailByID/{id}/{brID}', [BookingMainController::class, 'getBookingRequestDetailByID']);
        Route::post('/booking/addBookingRequestDetail', [BookingMainController::class, 'addBookingRequestDetail']);
        Route::patch('/booking/updateBookingRequestStatusByID/{id}', [BookingMainController::class, 'updateBookingRequestStatusByID']);
        Route::patch('/booking/updateBookingMainStatusByID/{id}', [BookingMainController::class, 'updateBookingMainStatusByID']); // Un-finished

        //Image and File Viewer
        Route::get('/viewer/pdfviewer/{filename}', [CommonDataController::class, 'fileView'])->where('filename', '.*'); // Un-finished
        Route::get('/viewer/imageviewer/{filename}', [CommonDataController::class, 'imageView'])->where('filename', '.*'); // Un-finished
        Route::get('/viewer/downloadfile/{filename}', [CommonDataController::class, 'downloadFileNImage'])->where('filename', '.*'); // Un-finished

    });

});


//!! Version 1

//Test
Route::post('/cp/test', [BaseController::class, 'getCpProfileDetails']);

//App Operations
Route::post("/cp/getCpProfileDetails/{id}", [CpDetailsController::class, 'cpProfileDetails']); // Done to V2
Route::post("/cp/getEmailVerificationStatus", [CpDetailsController::class, 'cpEmailVerificationStatusCheck']); // Done to V2
Route::post("/cp/updateEmailVerificationStatus", [CpDetailsController::class, 'cpEmailVerificationStatusUpdate']); // Done to V2
Route::post("/cp/getFirstTimeStatus", [CpDetailsController::class, 'cpFirstTimeStatusCheck']); // Done to V2

//Common
Route::get("/cp/getStateList", [CommonDataController::class, 'getStateList']); // Done to V2
Route::get("/cp/getServiceMainList", [CommonDataController::class, 'getServiceMainList']); // Done to V2
Route::get("/cp/getSubServiceList", [CommonDataController::class, 'getSubServiceList']); // Done to V2
Route::get("/cp/getCompetentPersonTypeList", [CommonDataController::class, 'getCompententPersonTypeList']); // Done to V2

Route::put('/cp/completeProfile', [CpDetailsController::class, 'cpCompleteProfile']); // Done to V2
Route::put('/cp/updateCpProfileInfo', [CpDetailsController::class, 'updateProfileInfo']); // Done to V2

//Booking Operations
Route::post('/cp/bookingMainList', [BookingMainController::class, 'cpBookingInfo']); // Done to V2
Route::post('/cp/cpBookingRequest', [BookingMainController::class, 'cpBookingRequest']);
Route::post('/cp/bookingDetails', [BookingMainController::class, 'cpBookingDetailsList']); // Done to V2
Route::post('/cp/addBookingRequest', [BookingMainController::class, 'addBookingRequest']); // Done to V2
Route::post('/cp/updateBookingMain', [BookingMainController::class, 'updateStatusBookingMain']); // Done to V2
Route::post('/cp/updateBookingRequest', [BookingMainController::class, 'updateStatusBookingRequest']); // Done to V2

//Job Operation
Route::post('/cp/getJobList', [JobMainController::class, 'cpJobMainListDetails']);
Route::post('/cp/getJobDetails', [JobMainController::class, 'cpJobMainDetails']);
Route::post('/cp/getJobPaymentDetails', [JobMainController::class, 'cpJobPaymentDetails']);
Route::post('/cp/getJobResultDetails', [JobMainController::class, 'cpJobResultDetails']);
Route::post('/cp/addJobResultDetails', [JobMainController::class, 'cpAddJobResultDetails']);
Route::post('/cp/updateJobMainProgressCompleteStatus', [JobMainController::class, 'updateCpJobMainProgressCompleteStatus']);
Route::post('/cp/uploadJobResultFinalReport', [JobMainController::class, 'uploadJobResultFinalDocument']);

//Service Operations
Route::post('/cp/getCpServiceList', [CommonDataController::class, 'getServiceList']); // Done to V2
Route::post('/cp/addServiceInfo', [ServiceController::class, 'addServiceDetails']); // Done to V2
Route::post('/cp/getMyServiceDetailsList', [ServiceController::class, 'getMyServiceDetailsList']); // Done to V2
Route::post('/cp/updateServiceDetails', [ServiceController::class, 'updateServiceDetails']); // Done to V2
Route::post('/cp/deleteServiceDetails', [ServiceController::class, 'deleteServiceDetails']); // Done to V2

//Certificate Operations
Route::post('/cp/getMyCertificateDetailsList', [CertificateController::class, 'getMyCertificateDetailsList']); // Done to V2
Route::post('/cp/addCertificateInfo', [CertificateController::class, 'addCertificateDetails']); // Done to V2
Route::post('/cp/updateCertificateDetails', [CertificateController::class, 'updateCertificateDetails']); // Done to V2
Route::post('/cp/deleteCertificateDetails', [CertificateController::class, 'deleteCertificateDetails']); // Done to V2

//Subscription Operations
Route::post('/cp/uploadSubscriptionPayment', [PaymentSubscribeController::class, 'uploadSubscriptionPaymentData']);
Route::post('/cp/checkUserSubscription', [PaymentSubscribeController::class, 'checkUserSubscription']);
Route::post('/cp/checkIfUserCP', [PaymentSubscribeController::class, 'checkIfUserCP']);

//Normal User Operations
Route::post("/clientUser/getClientUserProfileDetails", [ClientUserDetailsController::class, 'clientUserProfileDetails']); // Done to V2

//PDF View
// routes/web.php or routes/api.php

Route::get('/pdfviewer/{filename}', [CommonDataController::class, 'pdfView'])->where('filename', '.*'); // Done to V2


//Auth
Route::post("/auth/register", [AuthController::class, 'register']); // Done to V2
Route::post("/auth/login", [AuthController::class, 'login']); // Done to V2
Route::post("/auth/logout", [AuthController::class, 'logout']); // Done to V2



