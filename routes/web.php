<?php

use App\Http\Middleware\CustomerAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', 'App\Http\Controllers\Auth\LogoutController@index')->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return Redirect::to('home');
    } else {
        return view('index');
    }
});

//-------------------User Dashboard----------------------
Route::get('/dashboard', [
    'uses' => 'App\Http\Controllers\WebLinks\DashboardController@pbxdomaindetail',
    //'middleware' => 'roles:dashboardpbxdomaindetail',
    'as' => 'web.dashboard.pbxdomaindetail'
]);
//-------------------Auth----------------------
Route::get('/forgotpassword', function () {
    return view('auth.forgotpassword');
});
Route::get('/password/reset', function () {
    return view('auth.resetpassword');
});
Route::get('/users/email/verification/{token}', [
    'uses' => 'App\Http\Controllers\Auth\ResetPasswordController@emailverification',
    //'middleware' => 'roles:useremailverification',
    'as' => 'web.auth.emailverification'
]);

//--------------------SMS/MMS History---------------------
Route::get('/smsmmshistory', [
    'uses' => 'App\Http\Controllers\WebLinks\MessagelogController@smsmmshistory',
    //'middleware' => 'roles:smsmmshistory',
    'as' => 'web.main.smsmmshistory'
]);

//--------------------API Collection---------------------
Route::get('/apireview', [
    'uses' => 'App\Http\Controllers\WebLinks\ApiController@index',
    //'middleware' => 'roles:apireview',
    'as' => 'web.api.review'
]);

Route::get('/tenstreetreview', [
    'uses' => 'App\Http\Controllers\WebLinks\ApiController@tenstreet',
    //'middleware' => 'roles:tenstreetreview',
    'as' => 'web.api.tenstreetreview'
])->middleware(CustomerAdmin::class);

Route::get('/apicollection', [
    'uses' => 'App\Http\Controllers\WebLinks\ApiController@collection',
    //'middleware' => 'roles:apicollection',
    'as' => 'web.api.collection'
]);

//--------------------User Management---------------------
Route::get('/manageusers', [
    'uses' => 'App\Http\Controllers\WebLinks\UsersController@manageusers',
    //'middleware' => 'roles:manageusers',
    'as' => 'web.users.manage'
]);

Route::get('/userloginhistory', [
    'uses' => 'App\Http\Controllers\WebLinks\UsersController@loginhistory',
    //'middleware' => 'roles:userloginhistory',
    'as' => 'web.users.loginhistory'
]);

//------------PBX--------------
Route::get('/testpeerless', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@testpeerless',
    //'middleware' => 'roles:testpeerless',
    'as' => 'web.admin.testpeerless'
]);

Route::get('/pbxdomains', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@pbxdomains',
    //'middleware' => 'roles:pbxdomains',
    'as' => 'web.admin.pbxdomains'
]);

Route::get('/pbxdomain/{domain}', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@pbxdomaindetail',
    //'middleware' => 'roles:pbxdomaindetail',
    'as' => 'web.admin.pbxdomaindetail'
]);

Route::get('/pbxdomainsummary', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@pbxdomainsummary',
    //'middleware' => 'roles:pbxdomainsummary',
    'as' => 'web.admin.pbxdomainsummary'
]);

Route::get('/pbxdomainextension', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@pbxdomainextension',
    //'middleware' => 'roles:pbxdomainextension',
    'as' => 'web.admin.pbxdomainextension'
]);

Route::get('/pbxsmsenablednumber', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@pbxsmsenablednumber',
    //'middleware' => 'roles:pbxsmsenablednumber',
    'as' => 'web.admin.pbxsmsenablednumber'
]);

Route::get('/resendfailedmessages', [
    'uses' => 'App\Http\Controllers\WebLinks\PbxController@resendfailedmessages',
    //'middleware' => 'roles:resendfailedmessages',
    'as' => 'web.admin.resendfailedmessages'
]);

//------------Troubleshooting--------------
Route::get('/failedjobs', [
    'uses' => 'App\Http\Controllers\WebLinks\TroubleshootingController@failedjobs',
    //'middleware' => 'roles:failedjobs',
    'as' => 'web.admin.failedjobs'
]);

//------------Customers--------------
Route::get('/managecustomers', [
    'uses' => 'App\Http\Controllers\WebLinks\CustomerController@managecustomers',
    //'middleware' => 'roles:managecustomers',
    'as' => 'web.admin.managecustomers'
]);
Route::get('/tenstreetcustomerconfiguration', [
    'uses' => 'App\Http\Controllers\WebLinks\CustomerController@tenstreetconfiguration',
    //'middleware' => 'roles:tenstreetcustomerconfiguration',
    'as' => 'web.admin.tenstreetcustomerconfiguration'
]);
// added by Tom
Route::get('/tenstreetcallrelayconfig', [
    'uses' => 'App\Http\Controllers\WebLinks\CustomerController@tenstreetcallrelayconfig',
    //'middleware' => 'roles:tenstreetcallrelayconfig',
    'as' => 'web.admin.tenstreetcallrelayconfig'
]);

//------------Accounting--------------
Route::get('/accounttodomain', [
    'uses' => 'App\Http\Controllers\WebLinks\AccountingController@accounttodomain',
    //'middleware' => 'roles:accounttodomain',
    'as' => 'web.admin.accounttodomain'
]);
Route::get('/accountingmonthlydata', [
    'uses' => 'App\Http\Controllers\WebLinks\AccountingController@accountingmonthlydata',
    //'middleware' => 'roles:accountingmonthlydata',
    'as' => 'web.admin.accountingmonthlydata'
]);

//------------Automatedcallqueue--------------
Route::get('/tenstreetcallrequests', [
    'uses' => 'App\Http\Controllers\WebLinks\AutomatedcallqueueController@tenstreetcallrequests',
    //'middleware' => 'roles:tenstreetcallrequests',
    'as' => 'web.admin.tenstreetcallrequests'
])->middleware(CustomerAdmin::class);;
Route::get('/tenstreetrequestscalled', [
    'uses' => 'App\Http\Controllers\WebLinks\AutomatedcallqueueController@tenstreetrequestscalled',
    //'middleware' => 'roles:tenstreetrequestscalled',
    'as' => 'web.admin.tenstreetrequestscalled'
])->middleware(CustomerAdmin::class);;
Route::get('/agentavailabilityconfig', [
    'uses' => 'App\Http\Controllers\WebLinks\AutomatedcallqueueController@agentavailabilityconfig',
    //'middleware' => 'roles:agentavailabilityconfig',
    'as' => 'web.admin.agentavailabilityconfig'
])->middleware(CustomerAdmin::class);;

//------------Infrastructure--------------
Route::get('/switchstatus', [
    'uses' => 'App\Http\Controllers\WebLinks\InfrastructureController@switchstatus',
    //'middleware' => 'roles:switchstatus',
    'as' => 'web.admin.switchstatus'
]);

//------------AABO--------------
Route::get('/aaborelay', [
    'uses' => 'App\Http\Controllers\WebLinks\AaboController@aaborelay',
    //'middleware' => 'roles:switchstatus',
    'as' => 'web.admin.aaborelay'
]);

//------------APIS-------------
Route::post('/apis/collection', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@getcollection',
    //'middleware' => 'roles:apicollection',
    'as' => 'web.apis.collection'
]);
Route::post('/v2/users/collector', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@getcollection',
    //'middleware' => 'roles:apicollection',
    'as' => 'apisv2.users.collection'
]);
Route::post('/aabo/collector', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@outboundpeerlessforaabo',
    //'middleware' => 'roles:apicollection',
    'as' => 'api.collector.outboundpeerlessforaabo'
]);
Route::post('/messages', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@inboundpeerless',
    //'middleware' => 'roles:inboundpeerless',
    'as' => 'web.apis.inboundpeerless'
]);
Route::post('/peerless/messages', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@inboundpeerless',
    //'middleware' => 'roles:inboundpeerless',
    'as' => 'web.apis.peerlessmessages'
]);
Route::post('/gptransco/tenstreet', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@tenstreet',
    //'middleware' => 'roles:tenstreet',
    'as' => 'web.apis.tenstreet'
]);
Route::post('readagentsinqueue', [
    'uses' => 'App\Http\Controllers\Apis\TenstreetController@read_agents_in_queue',
    //'middleware' => 'roles:read_agents_in_queue',
    'as' => 'apisv2.tenstreet.read_agents_in_queue'
]);
Route::post('makeacall', [
    'uses' => 'App\Http\Controllers\Apis\TenstreetController@makeacall',
    //'middleware' => 'roles:makeacall',
    'as' => 'apisv2.tenstreet.makeacall'
]);
Route::post('/gptransco/tenstreetlog', [
    'uses' => 'App\Http\Controllers\Apis\CollectionController@tenstreetLog',
    //'middleware' => 'roles:tenstreet',
    'as' => 'web.apis.tenstreetlog'
]);
//----------------Cronjob-----------------
Route::get('/cronjob/pull/netsapiensdomains', [
    'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomains',
    //'middleware' => 'roles:pullnetsapiensdomains',
    'as' => 'web.cronjob.pulldomains'
]);
Route::get('/cronjob/pull/netsapiensdomainsummary', [
    'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomainsummaries',
    //'middleware' => 'roles:netsapiensdomainsummary',
    'as' => 'web.cronjob.pulldomainsummary'
]);
Route::get('/cronjob/pull/netsapienscollectextensions', [
    'uses' => 'App\Http\Controllers\Apis\NetsapiensController@collectextensions',
    //'middleware' => 'roles:netsapienscollectextensions',
    'as' => 'web.cronjob.pullcollectextensions'
]);
Route::get('/cronjob/pull/netsapiensdomainextensionwithsms', [
    'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomainextensionwithsms',
    //'middleware' => 'roles:netsapiensdomainextensionwithsms',
    'as' => 'web.cronjob.pulldomainextensionwithsms'
]);
Route::get('/cronjob/pbx/makeacall', [
    'uses' => 'App\Http\Controllers\Apis\TenstreetController@makeacalltopbx',
    //'middleware' => 'roles:makeacalltopbx',
    'as' => 'web.cronjob.makeacalltopbx'
]);
Route::get('/cronjob/countdailybillingnumbers', [
    'uses' => 'App\Http\Controllers\Apis\AccountingController@countdailybillingnumbers',
    //'middleware' => 'roles:countdailybillingnumbers',
    'as' => 'web.cronjob.countdailybillingnumbers'
]);
Route::get('/freshbooks/authentication', [
    'uses' => 'App\Http\Controllers\Apis\FreshbooksController@generateAuthToken',
    //'middleware' => 'roles:authentication',
    'as' => 'web.freshbooks.authentication'
]);
