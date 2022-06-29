<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('resetuserpassword', [
    'uses' => 'App\Http\Controllers\Auth\ResetPasswordController@forgotpassword',
    'as' => 'api.auth.forgotpassword'
]);

/*******************************************************************
*              This is the Web API Group
*******************************************************************/
$router->group(['prefix' => 'api-v1'], function() use ($router)
{
    /*******************************************************************
    *              Auth Module
    *******************************************************************/


    Route::post('setuserpassword', [
        'uses' => 'App\Http\Controllers\Auth\ResetPasswordController@setpassword',
        'as' => 'api.auth.setpassword'
    ]);


    /*******************************************************************
    *              API Collection Module
    *******************************************************************/
    Route::post('smshistory', [
        'uses' => 'App\Http\Controllers\ApiManagement\MessagelogController@smshistory',
        'as' => 'api.sms.history'
    ]);
    Route::get('ajaxsmsmmshistory', [
        'uses' => 'App\Http\Controllers\ApiManagement\MessagelogController@ajaxsmsmmshistory',
        'as' => 'api.sms.ajaxsmsmmshistory'
    ]);
    Route::get('domainoverview', [
        'uses' => 'App\Http\Controllers\ApiManagement\MessagelogController@domainoverview',
        'as' => 'api.sms.domainoverview'
    ]);
    Route::get('failedsmsmmshistory', [
        'uses' => 'App\Http\Controllers\ApiManagement\MessagelogController@failedsmsmmshistory',
        'as' => 'api.sms.failedsmsmmshistory'
    ]);
    Route::post('resendfailedmessages', [
        'uses' => 'App\Http\Controllers\Apis\CollectionController@resendfailedmessages',
        'as' => 'api.pbx.resendfailedmessages'
    ]);

    /*******************************************************************
    *              API Automatedcallqueue Module
    *******************************************************************/
    Route::get('tenstreetcallrequests', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@tenstreetcallrequests',
        'as' => 'api.automatedcallqueue.tenstreetcallrequests'
    ]);
    Route::get('tenstreetarchivedcallrequests', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@tenstreetarchivedcallrequests',
        'as' => 'api.automatedcallqueue.tenstreetarchivedcallrequests'
    ]);
    Route::get('tenstreetrequestscalled', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@tenstreetrequestscalled',
        'as' => 'api.automatedcallqueue.tenstreetrequestscalled'
    ]);
    Route::post('saveweeklyschedule', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@saveweeklyschedule',
        'as' => 'api.agentavailabilityconfig.saveweeklyschedule'
    ]);
    Route::post('addnonworkingday', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@addnonworkingday',
        'as' => 'api.agentavailabilityconfig.addnonworkingday'
    ]);
    Route::post('deletenonworkingday', [
        'uses' => 'App\Http\Controllers\ApiManagement\AutomatedcallqueueController@deletenonworkingday',
        'as' => 'api.agentavailabilityconfig.deletenonworkingday'
    ]);

    /*******************************************************************
    *              API Collection Module
    *******************************************************************/
    Route::get('apireviewdata', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@apireviewdata',
        'as' => 'api.apicollection.apireviewdata'
    ]);
    Route::get('apireviewdata', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@ajaxapireviewdata',
        'as' => 'api.apicollection.ajaxapireviewdata'
    ]);
    Route::get('ajaxtenstreetreviewdata', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@ajaxtenstreetreviewdata',
        'as' => 'api.apicollection.ajaxtenstreetreviewdata'
    ]);
    Route::post('getapicollection', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@getapicollection',
        'as' => 'api.apicollection.getapicollection'
    ]);
    Route::post('loaddetails', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@loaddetails',
        //'middleware' => 'auth:api',
        'as' => 'api.apicollection.loaddetails'
    ]);
    Route::post('loadtenstreetdetails', [
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@loadtenstreetdetails',
        //'middleware' => 'auth:api',
        'as' => 'api.apicollection.loadtenstreetdetails'
    ]);

    Route::post('set_current_time_zone', [
        'as' => 'api.ajax.setcurrenttimezone',
        'uses' => 'App\Http\Controllers\ApiManagement\ApicollectionController@setCurrentTimeZone'
    ]);

    /*******************************************************************
    *              Dashboard
    *******************************************************************/
    Route::post('dashboardsmshourly', [
        'uses' => 'App\Http\Controllers\Administration\DashboardController@dashboardsmshourly',
        'as' => 'api.dashboard.smshourly'
    ]);
    Route::post('dashboardsmsdaily', [
        'uses' => 'App\Http\Controllers\Administration\DashboardController@dashboardsmsdaily',
        'as' => 'api.dashboard.smsdaily'
    ]);

    /*******************************************************************
    *              Administration
    *******************************************************************/
    Route::post('infrastructureswitchstatus', [
        'uses' => 'App\Http\Controllers\Administration\InfrastructureController@switchstatus',
        'as' => 'api.infrastructure.switchstatus'
    ]);
    Route::get('manageusersdata', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@usersdata',
        'as' => 'api.users.getlist'
    ]);
    Route::get('userloginhistory', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@userloginhistory',
        'as' => 'api.users.getuserloginhistory'
    ]);
    Route::post('getuser', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@get',
        'as' => 'api.users.get'
    ]);
    Route::post('adduser', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@add',
        'as' => 'api.users.add'
    ]);
    Route::put('updateuser', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@update',
        'as' => 'api.users.update'
    ]);
    Route::post('addcustomer', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@addnormaluser',
        'as' => 'api.customers.add'
    ]);
    Route::post('getcustomerdomains', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@getcustomerdomains',
        'as' => 'api.customers.getcustomerdomains'
    ]);
    Route::post('updatecustomerdomains', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@updatedomains',
        'as' => 'api.customers.updatedomains'
    ]);
    Route::post('updatecustomerstatus', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@updatestatus',
        'as' => 'api.customers.updatestatus'
    ]);
    Route::post('resetcustomerpassword', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@sendnewpassword',
        'as' => 'api.customers.resetpassword'
    ]);

    Route::post('addclient', [
        'uses' => 'App\Http\Controllers\Administration\AccountingclientController@add',
        'as' => 'api.clients.add'
    ]);
    Route::post('editclient', [
        'uses' => 'App\Http\Controllers\Administration\AccountingclientController@edit',
        'as' => 'api.clients.edit'
    ]);
    Route::post('deleteclient', [
        'uses' => 'App\Http\Controllers\Administration\AccountingclientController@delete',
        'as' => 'api.clients.delete'
    ]);
    Route::post('getclient', [
        'uses' => 'App\Http\Controllers\Administration\AccountingclientController@get',
        'as' => 'api.clients.get'
    ]);
    Route::get('getmonthlydata', [
        'uses' => 'App\Http\Controllers\Apis\AccountingController@getmonthlydata',
        'as' => 'api.accounting.getmonthlydata'
    ]);
    Route::post('getstats', [
        'uses' => 'App\Http\Controllers\Apis\AccountingController@getstats',
        'as' => 'api.accounting.getstats'
    ]);

    Route::post('addaaborelay', [
        'uses' => 'App\Http\Controllers\Apis\AaborelayController@add',
        'as' => 'api.aaborelay.add'
    ]);
    Route::post('editaaborelay', [
        'uses' => 'App\Http\Controllers\Apis\AaborelayController@edit',
        'as' => 'api.aaborelay.edit'
    ]);
    Route::post('deleteaaborelay', [
        'uses' => 'App\Http\Controllers\Apis\AaborelayController@delete',
        'as' => 'api.aaborelay.delete'
    ]);
    Route::post('getaaborelay', [
        'uses' => 'App\Http\Controllers\Apis\AaborelayController@get',
        'as' => 'api.aaborelay.get'
    ]);

    Route::post('addtenstreetcustomerconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@addtenstreetcustomerconfig',
        'as' => 'api.tenstreetcustomerconfig.add'
    ]);
    Route::post('updatetenstreetcustomerconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@updatetenstreetcustomerconfig',
        'as' => 'api.tenstreetcustomerconfig.update'
    ]);
    Route::post('gettenstreetcustomerconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@gettenstreetcustomerconfig',
        'as' => 'api.tenstreetcustomerconfig.get'
    ]);

    Route::post('addtenstreetcallrelayconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@addTenstreetCallRelayConfig',
        'as' => 'api.tenstreetcallrelayconfig.add'
    ]);
    Route::post('updatetenstreetcallrelayconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@updateTenstreetCallRelayConfig',
        'as' => 'api.tenstreetcallrelayconfig.update'
    ]);
    Route::post('deletetenstreetcallrelayconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@deleteTenstreetCallRelayConfig',
        'as' => 'api.tenstreetcallrelayconfig.delete'
    ]);
    Route::post('gettenstreetcallrelayconfig', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@getTenstreetCallRelayConfig',
        'as' => 'api.tenstreetcallrelayconfig.get'
    ]);
    /////////////////////////////////////////////////

    Route::post('tenstreetcallrequestssendtoqueue', [
        'uses' => 'App\Http\Controllers\Apis\TenstreetController@sendtoqueue',
        'as' => 'api.tenstreetcallrequests.sendtoqueue'
    ]);
    Route::post('tenstreetcallrequestsarchivecallrequest', [
        'uses' => 'App\Http\Controllers\Apis\TenstreetController@archivecallrequest',
        'as' => 'api.tenstreetcallrequests.archivecallrequest'
    ]);


    Route::post('resetuserpassword', [
        'uses' => 'App\Http\Controllers\Administration\UsermanagementController@resetpassword',
        'as' => 'api.users.resetpassword'
    ]);
    Route::post('sendnewpassword', [
        'uses' => 'App\Http\Controllers\Auth\ResetPasswordController@sendnewpassword',
        'as' => 'api.users.sendnewpassword'
    ]);

    /*******************************************************************
    *              APIs
    *******************************************************************/
    Route::post('submitmessage/{partnerID}', [
        'uses' => 'App\Http\Controllers\Apis\PeerlessController@submitMessage',
        //'middleware' => 'roles:submitmessage',
        'as' => 'apisv2.peerless.submitmessage'
    ]);
    Route::post('pullnetsapiensdomains', [
        'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomains',
        //'middleware' => 'roles:pullnetsapiensdomains',
        'as' => 'apisv2.netsapiens.pulldomains'
    ]);
    Route::post('pullnetsapiensdomainsummaries', [
        'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomainsummaries',
        //'middleware' => 'roles:pullnetsapiensdomainsummaries',
        'as' => 'apisv2.netsapiens.pulldomainsummaries'
    ]);
    Route::post('pullnetsapienscollectextensions', [
        'uses' => 'App\Http\Controllers\Apis\NetsapiensController@collectextensions',
        //'middleware' => 'roles:pullnetsapienscollectextensions',
        'as' => 'apisv2.netsapiens.collectextensions'
    ]);
    Route::post('pulldomainextensionwithsms', [
        'uses' => 'App\Http\Controllers\Apis\NetsapiensController@pulldomainextensionwithsms',
        //'middleware' => 'roles:pulldomainextensionwithsms',
        'as' => 'apisv2.netsapiens.pulldomainextensionwithsms'
    ]);

});
