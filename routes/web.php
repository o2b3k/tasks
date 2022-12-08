<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



Route::get('/', ['uses' => 'HomeController@landingPage'])->middleware(['XSS']);

Route::get(

  '/{slug}/invoices/{id}/pay', [
           'as' => 'pay.invoice',
           'uses' => 'InvoiceController@payinvoice',
       ]
);


Route::get('/check','HomeController@check')->middleware(['auth','XSS']);
Route::get('/home', ['as' => 'home','uses' =>'HomeController@index'])->middleware(['auth','XSS']);


Route::get('login/{lang?}', 'Auth\AuthenticatedSessionController@showLoginForm')->name('login')->middleware(['XSS']);
Route::get('register/{lang?}', 'Auth\RegisteredUserController@showRegistrationForm')->name('register')->middleware(['XSS']);
Route::get('password/resets/{lang?}', 'Auth\AuthenticatedSessionController@showLinkRequestForm')->name('password.request')->middleware(['XSS']);

Route::prefix('client')->as('client.')->group(function() {
    Route::post('login', 'Auth\AuthenticatedSessionController@clientLogin')->name('login')->middleware(['XSS']);
    Route::get('login/{lang?}', 'Auth\AuthenticatedSessionController@showClientLoginForm')->name('login')->middleware(['XSS']);
    Route::post('logout', 'ClientController@clientLogout')->name('logout')->middleware(['auth:client','XSS']);


    Route::get('/my-account',['as' => 'users.my.account','uses' =>'UserController@account'])->middleware(['auth:client','XSS']);
    Route::post('/my-account',['as' => 'update.account','uses' =>'UserController@update'])->middleware(['auth:client','XSS']);
    Route::post('/my-account/password',['as' => 'update.password','uses' =>'UserController@updatePassword'])->middleware(['auth:client','XSS']);
    Route::post('/my-account/billing',['as' => 'update.billing','uses' =>'ClientController@updateBilling'])->middleware(['auth:client','XSS']);
    Route::delete('/my-account',['as' => 'delete.avatar','uses' =>'UserController@deleteAvatar'])->middleware(['auth:client','XSS']);

    // project
    Route::get('/{slug}/projects',['as' => 'projects.index','uses' =>'ProjectController@index'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}',['as' => 'projects.show','uses' =>'ProjectController@show'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone','uses' =>'ProjectController@milestone'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/milestone/{id}/store',['as' => 'projects.milestone.store','uses' =>'ProjectController@milestoneStore'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}/show',['as' => 'projects.milestone.show','uses' =>'ProjectController@milestoneShow'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}/edit',['as' => 'projects.milestone.edit','uses' =>'ProjectController@milestoneEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/milestone/{id}/update',['as' => 'projects.milestone.update','uses' =>'ProjectController@milestoneUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone.destroy','uses' =>'ProjectController@milestoneDestroy'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/file/{fid}',['as' => 'projects.file.download','uses' =>'ProjectController@fileDownload'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/{id}/file/delete/{fid}',['as' => 'projects.file.delete','uses' =>'ProjectController@fileDelete'])->middleware(['auth:client','XSS']);
    
    // Task Board
    Route::get('/{slug}/projects/{id}/task-board',['as' => 'projects.task.board','uses' =>'ProjectController@taskBoard'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/create',['as' => 'tasks.create','uses' =>'ProjectController@taskCreate'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board',['as' => 'tasks.store','uses' =>'ProjectController@taskStore'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board/order-update',['as' => 'tasks.update.order','uses' =>'ProjectController@taskOrderUpdate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/edit/{tid}',['as' => 'tasks.edit','uses' =>'ProjectController@taskEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board/{tid}/update',['as' => 'tasks.update','uses' =>'ProjectController@taskUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/{id}/task-board/{tid}',['as' => 'tasks.destroy','uses' =>'ProjectController@taskDestroy'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/{tid}/{cid?}',['as' => 'tasks.show','uses' =>'ProjectController@taskShow'])->middleware(['auth:client','XSS']);;

    Route::get('/{slug}/timesheet',['as' => 'timesheet.index','uses' =>'ProjectController@timesheet'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/timesheet-table-view', 'ProjectController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/timesheet/{id}',['as' => 'projects.timesheet.index','uses' =>'ProjectController@projectsTimesheet'])->middleware(['auth:client','XSS']);

    // Gantt Chart
    Route::get('/{slug}/projects/{id}/gantt/{duration?}',['as' => 'projects.gantt','uses' =>'ProjectController@gantt'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/gantt',['as' => 'projects.gantt.post','uses' =>'ProjectController@ganttPost'])->middleware(['auth:client','XSS']);


    // bug report
    Route::get('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report','uses' =>'ProjectController@bugReport'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/create',['as' => 'projects.bug.report.create','uses' =>'ProjectController@bugReportCreate'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report.store','uses' =>'ProjectController@bugReportStore'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report/order-update',['as' => 'projects.bug.report.update.order','uses' =>'ProjectController@bugReportOrderUpdate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/{bid}/show',['as' => 'projects.bug.report.show','uses' =>'ProjectController@bugReportShow'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/{bid}/edit',['as' => 'projects.bug.report.edit','uses' =>'ProjectController@bugReportEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report/{bid}/update',['as' => 'projects.bug.report.update','uses' =>'ProjectController@bugReportUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/{id}/bug_report/{bid}',['as' => 'projects.bug.report.destroy','uses' =>'ProjectController@bugReportDestroy'])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/searchJson/{search?}',['as' => 'search.json','uses' =>'ProjectController@getSearchJson'])->middleware(['auth:client','XSS']);
    Route::get('/userProjectJson/{id}',['as' => 'user.project.json','uses' =>'UserController@getProjectUserJson'])->middleware(['auth:client','XSS']);
    Route::get('/projectMilestoneJson/{id}',['as' => 'project.milestone.json','uses' =>'UserController@getProjectMilestoneJson'])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/invoices',['as' => 'invoices.index','uses' =>'InvoiceController@index'])->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/invoices/{id}',['as' => 'invoices.show','uses' =>'InvoiceController@show'])->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/invoices/{id}/print',['as' => 'invoice.print','uses' =>'InvoiceController@printInvoice'])->middleware( 'XSS');
    Route::post('/{slug}/invoices/{id}/payment',['as' => 'invoice.payment','uses' =>'InvoiceController@addPayment'])->middleware(['auth:client', 'XSS']);
    Route::get('/workspace/{id}',['as' => 'change-workspace','uses' =>'WorkspaceController@changeCurrentWorkspace'])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/calendar/{id?}',['as' => 'calender.index','uses' =>'CalenderController@index'])->middleware(['auth:client','XSS']);

    Route::post('/{slug}/{id}/pay-with-paypal',['as' => 'pay.with.paypal','uses' =>'PaypalController@clientPayWithPaypal'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/{id}/get-payment-status',['as' => 'get.payment.status','uses' =>'PaypalController@clientGetPaymentStatus'])->middleware(['auth:client','XSS']);

    Route::get('/{slug?}', ['as' => 'home','uses' =>'HomeController@index'])->middleware(['auth:client','XSS']);


    ////**===================================== Project Reports =======================================================////

    Route::resource('/{slug}/project_report','ProjectReportController')->middleware(['auth:client','XSS']);
    Route::post('/{slug}/project_report_data','ProjectReportController@ajax_data')->name('projects.ajax')->middleware(['auth:client','XSS']);
    Route::post('/{slug}/project_report/{id}','ProjectReportController@show')->name('project_report.show')->middleware(['auth:client','XSS']);

    Route::post('/{slug}/project_report/tasks/{id}',['as' => 'tasks.report.ajaxdata','uses' =>'ProjectReportController@ajax_tasks_report'])->middleware(['auth:client','XSS']);



////**===================================== Client Contract Module =======================================================////
    Route::resource('/{slug}/contracts', 'ContractController')->middleware(['auth:client','XSS']);
    Route::get('/{slug}/signature/{id}', 'ContractController@signature')->name('signature')->middleware(['auth:client','XSS']);
    Route::post('/{slug}/signaturestore', 'ContractController@signatureStore')->name('signaturestore')->middleware(['auth:client','XSS']);

    Route::post('/{slug}/contract/{id}/file', ['as' => 'contracts.file.upload','uses' => 'ContractController@fileUpload',])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/contract/{id}/file/{fid}', ['as' => 'contracts.file.download','uses' => 'ContractController@fileDownload',])->middleware(['auth:client','XSS']);

   Route::delete('/{slug}/contract/{id}/file/delete', ['as' => 'contracts.file.delete','uses' => 'ContractController@fileDelete',])->middleware(['auth:client','XSS']);

   Route::post('/{slug}/contract/{id}/comment', ['as' => 'comment_store.store', 'uses' => 'ContractController@commentStore',])->middleware(['auth:client','XSS']);

   Route::get('/{slug}/contract/{id}/comment', ['as' => 'comment_store.destroy','uses' => 'ContractController@commentDestroy',])->middleware(['auth:client','XSS']);

   Route::post('/{slug}/contract/{id}/notes', ['as' => 'note_store.store', 'uses' => 'ContractController@noteStore',])->middleware(['auth:client','XSS']);
   Route::get('/{slug}/contract/{id}/notes', ['as' => 'note_store.destroy','uses' => 'ContractController@noteDestroy',])->middleware(['auth:client','XSS']);

   Route::post('/{slug}/contract/{id}/contract_description', 'ContractController@contract_descriptionStore')->name('contract.contract_description.store')->middleware(['auth:client']);

    //================================= Invoice Payment Gateways  ====================================//

    Route::post('/{slug}/invoice-pay-with-paystack/{invoice_id}',['as' => 'invoice.pay.with.paystack','uses' =>'PaystackPaymentController@invoicePayWithPaystack'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/paystack/{pay_id}/{invoice_id}', ['as' => 'invoice.paystack','uses' => 'PaystackPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-flaterwave/{invoice_id}',['as' => 'invoice.pay.with.flaterwave','uses' =>'FlutterwavePaymentController@invoicePayWithFlutterwave'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/flaterwave/{txref}/{invoice_id}', ['as' => 'invoice.flaterwave','uses' => 'FlutterwavePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-razorpay/{invoice_id}',['as' => 'invoice.pay.with.razorpay','uses' =>'RazorpayPaymentController@invoicePayWithRazorpay'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/razorpay/{txref}/{invoice_id}', ['as' => 'invoice.razorpay','uses' => 'RazorpayPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-paytm/{invoice_id}',['as' => 'invoice.pay.with.paytm','uses' =>'PaytmPaymentController@invoicePayWithPaytm'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/invoice/paytm/{invoice}', ['as' => 'invoice.paytm','uses' => 'PaytmPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-mercado/{invoice_id}',['as' => 'invoice.pay.with.mercado','uses' =>'MercadoPaymentController@invoicePayWithMercado'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/mercado/{invoice}', ['as' => 'invoice.mercado','uses' => 'MercadoPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-mollie/{invoice_id}',['as' => 'invoice.pay.with.mollie','uses' =>'MolliePaymentController@invoicePayWithMollie'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/mollie/{invoice}', ['as' => 'invoice.mollie','uses' => 'MolliePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-skrill/{invoice_id}',['as' => 'invoice.pay.with.skrill','uses' =>'SkrillPaymentController@invoicePayWithSkrill'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/skrill/{invoice}', ['as' => 'invoice.skrill','uses' => 'SkrillPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-coingate/{invoice_id}',['as' => 'invoice.pay.with.coingate','uses' =>'CoingatePaymentController@invoicePayWithCoingate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/coingate/{invoice}', ['as' => 'invoice.coingate','uses' => 'CoingatePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    //================================= End Invoice Payment Gateways  ====================================//
    
    Route::get('/{slug}/zoom-meeting',['as' => 'zoom-meeting.index','uses' =>'ZoomMeetingController@index'])->middleware(['auth:client']);

});

Route::any('/plan/error/{flag}', 'PaymentWallPaymentController@paymenterror')->name('callback.error')->middleware(['auth','XSS']);
Route::post('paymentwall', ['as' => 'paymentwall', 'uses' => 'PaymentWallPaymentController@index'])->middleware(['auth','XSS']);
Route::post('plan-pay-with-paymentwall/{plan}', ['as' => 'plan.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@planPayWithPaymentwall'])->middleware(['auth','XSS']);


// Calender
Route::get('/{slug}/calendar/{id?}',['as' => 'calender.index','uses' =>'CalenderController@index'])->middleware(['auth','CheckPlan','XSS']);

// Chats

Route::get('/{slug}/notification/seen',['as' => 'notification.seen','uses' =>'UserController@notificationSeen']);
// End Chats

Route::get('/settings',['as' => 'settings.index','uses' =>'SettingsController@index'])->middleware(['auth','XSS']);
Route::post('/settings',['as' => 'settings.store','uses' =>'SettingsController@store'])->middleware(['XSS']);
Route::post('/email-settings',['as' => 'email.settings.store','uses' =>'SettingsController@emailSettingStore'])->middleware(['auth','XSS']);
Route::post('/payment-settings',['as' => 'payment.settings.store','uses' =>'SettingsController@paymentSettingStore'])->middleware(['auth','XSS']);
Route::post('/pusher-settings',['as' => 'pusher.settings.store','uses' =>'SettingsController@pusherSettingStore'])->middleware(['auth','XSS']);
Route::get('/test',['as' => 'test.email','uses' =>'SettingsController@testEmail'])->middleware(['auth','XSS']);
Route::post('/test/send',['as' => 'test.email.send','uses' =>'SettingsController@testEmailSend'])->middleware(['auth','XSS']);

Route::get('/{slug}/clients',['as' => 'clients.index','uses' =>'ClientController@index'])->middleware(['auth','CheckPlan','XSS']);
Route::post('/{slug}/clients',['as' => 'clients.store','uses' =>'ClientController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/clients/create',['as' => 'clients.create','uses' =>'ClientController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/clients/{id}/edit',['as' => 'clients.edit','uses' =>'ClientController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/clients/{id}/update',['as' => 'clients.update','uses' =>'ClientController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/clients/{id}',['as' => 'clients.destroy','uses' =>'ClientController@destroy'])->middleware(['auth','XSS']);
// User
Route::get('/usersJson/{id}',['as' => 'user.email.json','uses' =>'UserController@getUserJson'])->middleware(['auth','XSS']);
Route::get('/{slug}/searchJson/{search?}',['as' => 'search.json','uses' =>'ProjectController@getSearchJson'])->middleware(['auth','XSS']);
Route::get('/userProjectJson/{id}',['as' => 'user.project.json','uses' =>'UserController@getProjectUserJson'])->middleware(['auth','XSS']);
Route::get('/projectMilestoneJson/{id}',['as' => 'project.milestone.json','uses' =>'UserController@getProjectMilestoneJson'])->middleware(['auth','XSS']);
Route::get('/users',['as' => 'users.index','uses' =>'UserController@index'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/users/create',['as' => 'users.create','uses' =>'UserController@create'])->middleware(['auth','XSS']);
Route::post('/users/store',['as' => 'users.store','uses' =>'UserController@store'])->middleware(['auth','XSS']);
Route::delete('/users/{id}',['as' => 'users.delete','uses' =>'UserController@destroy'])->middleware(['auth','XSS']);
Route::get('/users/{id}',['as' => 'users.change.plan','uses' =>'UserController@changePlan'])->middleware(['auth','XSS']);
Route::get('/resetpassword/{id}',['as' => 'users.reset.password','uses' =>'UserController@resetPassword'])->middleware(['auth','XSS']);
Route::post('/changepassword/{id}',['as' => 'users.change.password','uses' =>'UserController@changePassword'])->middleware(['auth','XSS']);



Route::get('/{slug}/users',['as' => 'users.index','uses' =>'UserController@index'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/users/invite',['as' => 'users.invite','uses' =>'UserController@invite'])->middleware(['auth','XSS']);
Route::post('/{slug}/users/invite',['as' => 'users.invite.update','uses' =>'UserController@inviteUser'])->middleware(['auth','XSS']);
Route::get('/{slug}/users/edit/{id}',['as' => 'users.edit','uses' =>'UserController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/users/update/{id}',['as' => 'users.update','uses' =>'UserController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/users/{id}',['as' => 'users.remove','uses' =>'UserController@removeUser'])->middleware(['auth','XSS']);



Route::get('/my-account',['as' => 'users.my.account','uses' =>'UserController@account'])->middleware(['auth','XSS']);
Route::post('/my-account',['as' => 'update.account','uses' =>'UserController@update'])->middleware(['auth','XSS']);
Route::post('/my-account/password',['as' => 'update.password','uses' =>'UserController@updatePassword'])->middleware(['auth','XSS']);
Route::delete('/my-account',['as' => 'delete.avatar','uses' =>'UserController@deleteAvatar'])->middleware(['auth','XSS']);
Route::delete('/delete-my-account',['as' => 'delete.my.account','uses' =>'UserController@deleteMyAccount'])->middleware(['auth','XSS']);

Route::get('/plans',['as' => 'plans.index','uses' =>'PlanController@index'])->middleware(['auth','XSS']);
Route::get('/plans/create',['as' => 'plans.create','uses' =>'PlanController@create'])->middleware(['auth','XSS']);
Route::post('/plans',['as' => 'plans.store','uses' =>'PlanController@store'])->middleware(['auth','XSS']);
Route::get('/plans/{id}/edit',['as' => 'plans.edit','uses' =>'PlanController@edit'])->middleware(['auth','XSS']);
Route::post('/plans/{id}/update',['as' => 'plans.update','uses' =>'PlanController@update'])->middleware(['auth','XSS']);
Route::post('/user-plans/',['as' => 'update.user.plan','uses' =>'PlanController@userPlan'])->middleware(['auth','XSS']);
Route::get('/payment/{frequency}/{code}', ['as'=>'payment','uses'=>'PlanController@payment'])->middleware(['auth','XSS']);

Route::get('/orders',['as' => 'order.index','uses' =>'StripePaymentController@index'])->middleware(['auth','XSS']);
Route::post('/stripe', ['as'=>'stripe.post','uses'=>'StripePaymentController@stripePost'])->middleware(['auth','XSS']);

Route::get('/apply-coupon', ['as' => 'apply.coupon','uses' =>'CouponController@applyCoupon'])->middleware(['auth','XSS']);
Route::resource('coupons', 'CouponController')->middleware(['auth','XSS',]);

// Lang
Route::get('/admin/change_lang/{lang}',['as' => 'change_lang_admin','uses' =>'WorkspaceController@changeLangAdmin'])->middleware(['auth','XSS']);
Route::get('/workspace/{slug}/change_lang/{lang}',['as' => 'change_lang_workspace','uses' =>'WorkspaceController@changeLangWorkspace'])->middleware(['auth','XSS']);
Route::get('/workspace/{slug}/change_lang1/{lang}',['as' => 'change_lang_workspace1','uses' =>'WorkspaceController@changeLangWorkspace1'])->middleware(['auth:client','XSS']);

Route::get('/workspace/lang/create',['as' => 'create_lang_workspace','uses' =>'WorkspaceController@createLangWorkspace'])->middleware(['auth','XSS']);
Route::get('/workspace/lang/{lang?}',['as' => 'lang_workspace','uses' =>'WorkspaceController@langWorkspace'])->middleware(['auth','XSS']);
Route::post('/workspace/lang/{lang}',['as' => 'store_lang_data_workspace','uses' =>'WorkspaceController@storeLangDataWorkspace'])->middleware(['auth','XSS']);
Route::post('/workspace/lang',['as' => 'store_lang_workspace','uses' =>'WorkspaceController@storeLangWorkspace'])->middleware(['auth','XSS']);

// Workspace
Route::get('/workspace/{slug}/settings',['as' => 'workspace.settings','uses' =>'WorkspaceController@settings'])->middleware(['auth','XSS']);
Route::post('/workspace/{slug}/settings',['as' => 'workspace.settings.store','uses' =>'WorkspaceController@settingsStore'])->middleware(['auth','XSS']);

Route::post('/workspace',['as' => 'add-workspace','uses' =>'WorkspaceController@store'])->middleware(['auth','XSS']);
Route::delete('/workspace/{id}',['as' => 'delete-workspace','uses' =>'WorkspaceController@destroy'])->middleware(['auth','XSS']);
Route::delete('/workspace/leave/{id}',['as' => 'leave-workspace','uses' =>'WorkspaceController@leave'])->middleware(['auth','XSS']);
Route::get('/workspace/{id}',['as' => 'change-workspace','uses' =>'WorkspaceController@changeCurrentWorkspace'])->middleware(['auth','XSS']);



// project
Route::get('/{slug}/projects',['as' => 'projects.index','uses' =>'ProjectController@index'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/projects/create',['as' => 'projects.create','uses' =>'ProjectController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}',['as' => 'projects.show','uses' =>'ProjectController@show'])->middleware(['auth','CheckPlan','XSS']);
Route::post('/{slug}/projects',['as' => 'projects.store','uses' =>'ProjectController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/edit',['as' => 'projects.edit','uses' =>'ProjectController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/update',['as' => 'projects.update','uses' =>'ProjectController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}',['as' => 'projects.destroy','uses' =>'ProjectController@destroy'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/leave/{id}',['as' => 'projects.leave','uses' =>'ProjectController@leave'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/invite/{id}',['as' => 'projects.invite.popup','uses' =>'ProjectController@popup'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission','uses' =>'ProjectController@userPermission'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission.store','uses' =>'ProjectController@userPermissionStore'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/user/{uid}',['as' => 'projects.user.delete','uses' =>'ProjectController@userDelete'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/share/{id}',['as' => 'projects.share.popup','uses' =>'ProjectController@sharePopup'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/client/{uid}/permission',['as' => 'projects.client.permission','uses' =>'ProjectController@clientPermission'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/client/{uid}/permission',['as' => 'projects.client.permission.store','uses' =>'ProjectController@clientPermissionStore'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/client/{uid}',['as' => 'projects.client.delete','uses' =>'ProjectController@clientDelete'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/share/{id}',['as' => 'projects.share','uses' =>'ProjectController@share'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/invite/{id}/update',['as' => 'projects.invite.update','uses' =>'ProjectController@invite'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone','uses' =>'ProjectController@milestone'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/milestone/{id}/store',['as' => 'projects.milestone.store','uses' =>'ProjectController@milestoneStore'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}/show',['as' => 'projects.milestone.show','uses' =>'ProjectController@milestoneShow'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}/edit',['as' => 'projects.milestone.edit','uses' =>'ProjectController@milestoneEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/milestone/{id}/update',['as' => 'projects.milestone.update','uses' =>'ProjectController@milestoneUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone.destroy','uses' =>'ProjectController@milestoneDestroy'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/file',['as' => 'projects.file.upload','uses' =>'ProjectController@fileUpload'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/file/{fid}',['as' => 'projects.file.download','uses' =>'ProjectController@fileDownload'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/file/delete/{fid}',['as' => 'projects.file.delete','uses' =>'ProjectController@fileDelete'])->middleware(['auth','XSS']);

// Task Board
Route::get('/{slug}/projects/client/task-board/{code}',['as' => 'projects.client.task.board','uses' =>'ProjectController@taskBoard']);
Route::get('/{slug}/projects/{id}/task-board',['as' => 'projects.task.board','uses' =>'ProjectController@taskBoard'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/projects/{id}/task-board/create',['as' => 'tasks.create','uses' =>'ProjectController@taskCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board',['as' => 'tasks.store','uses' =>'ProjectController@taskStore'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board/order-update',['as' => 'tasks.update.order','uses' =>'ProjectController@taskOrderUpdate']);
Route::get('/{slug}/projects/{id}/task-board/edit/{tid}',['as' => 'tasks.edit','uses' =>'ProjectController@taskEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board/{tid}/update',['as' => 'tasks.update','uses' =>'ProjectController@taskUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/task-board/{tid}',['as' => 'tasks.destroy','uses' =>'ProjectController@taskDestroy'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/task-board/{tid}/{cid?}',['as' => 'tasks.show','uses' =>'ProjectController@taskShow']);
Route::post('/{slug}/projects/{id}/task-board/{tid}/drag',['as' => 'tasks.drag.event','uses' =>'ProjectController@taskDrag']);

// Gantt Chart
Route::get('/{slug}/projects/{id}/gantt/{duration?}',['as' => 'projects.gantt','uses' =>'ProjectController@gantt'])->middleware(['auth','CheckPlan','XSS']);
Route::post('/{slug}/projects/{id}/gantt',['as' => 'projects.gantt.post','uses' =>'ProjectController@ganttPost'])->middleware(['auth','XSS']);

Route::get('/{slug}/tasks',['as' => 'tasks.index','uses' =>'ProjectController@allTasks'])->middleware(['auth','CheckPlan','XSS']);
Route::post('/{slug}/tasks',['as' => 'tasks.ajax','uses' =>'ProjectController@ajax_tasks'])->middleware(['auth','XSS']);

// Timesheet
Route::get('/{slug}/tasks/{id?}',['as' => 'tasks.ajax','uses' =>'ProjectController@getTask'])->middleware(['auth','XSS']);
Route::get('/{slug}/timesheet',['as' => 'timesheet.index','uses' =>'ProjectController@timesheet'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/timesheet/create',['as' => 'timesheet.create','uses' =>'ProjectController@timesheetCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/timesheet/store',['as' => 'timesheet.store','uses' =>'ProjectController@timesheetStore'])->middleware(['auth','XSS']);
Route::get('/{slug}/timesheet/{id}/edit',['as' => 'timesheet.edit','uses' =>'ProjectController@timesheetEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/timesheet/{id}/update',['as' => 'timesheet.update','uses' =>'ProjectController@timesheetUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/timesheet/{id}',['as' => 'timesheet.destroy','uses' =>'ProjectController@timesheetDestroy'])->middleware(['auth','XSS']);

Route::post('/{slug}/projects/{id}/comment/{tid}/file/{cid?}',['as' => 'comment.store.file','uses' =>'ProjectController@commentStoreFile']);
Route::delete('/{slug}/projects/{id}/comment/{tid}/file/{fid}',['as' => 'comment.destroy.file','uses' =>'ProjectController@commentDestroyFile']);
Route::post('/{slug}/projects/{id}/comment/{tid}/{cid?}',['as' => 'comment.store','uses' =>'ProjectController@commentStore']);
Route::delete('/{slug}/projects/{id}/comment/{tid}/{cid}',['as' => 'comment.destroy','uses' =>'ProjectController@commentDestroy']);
Route::post('/{slug}/projects/{id}/sub-task/update/{stid}',['as' => 'subtask.update','uses' =>'ProjectController@subTaskUpdate']);
Route::post('/{slug}/projects/{id}/sub-task/{tid}/{cid?}',['as' => 'subtask.store','uses' =>'ProjectController@subTaskStore']);
Route::delete('/{slug}/projects/{id}/sub-task/{stid}',['as' => 'subtask.destroy','uses' =>'ProjectController@subTaskDestroy']);

// todo
//Route::get('/{slug}/todo',['as' => 'todos.index','uses' =>'TodoController@index'])->middleware(['auth','XSS']);
//Route::post('/{slug}/todo',['as' => 'todos.store','uses' =>'TodoController@store'])->middleware(['auth','XSS']);
//Route::post('/{slug}/todo',['as' => 'todos.update','uses' =>'TodoController@update'])->middleware(['auth','XSS']);
//Route::delete('/{slug}/todo',['as' => 'todos.destroy','uses' =>'TodoController@destroy'])->middleware(['auth','XSS']);

// note
Route::get('/{slug}/notes',['as' => 'notes.index','uses' =>'NoteController@index'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/notes/create',['as' => 'note.create','uses' =>'NoteController@create'])->middleware(['auth','XSS']);
Route::post('/{slug}/notes',['as' => 'notes.store','uses' =>'NoteController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/notes/{id}/edit',['as' => 'notes.edit','uses' =>'NoteController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/notes/{id}/update',['as' => 'notes.update','uses' =>'NoteController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/notes/{id}',['as' => 'notes.destroy','uses' =>'NoteController@destroy'])->middleware(['auth','XSS']);
// bug report
Route::get('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report','uses' =>'ProjectController@bugReport'])->middleware(['auth','CheckPlan','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/create',['as' => 'projects.bug.report.create','uses' =>'ProjectController@bugReportCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report.store','uses' =>'ProjectController@bugReportStore'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/bug_report/order-update',['as' => 'projects.bug.report.update.order','uses' =>'ProjectController@bugReportOrderUpdate'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/{bid}/show',['as' => 'projects.bug.report.show','uses' =>'ProjectController@bugReportShow'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/{bid}/edit',['as' => 'projects.bug.report.edit','uses' =>'ProjectController@bugReportEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/bug_report/{bid}/update',['as' => 'projects.bug.report.update','uses' =>'ProjectController@bugReportUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/bug_report/{bid}',['as' => 'projects.bug.report.destroy','uses' =>'ProjectController@bugReportDestroy'])->middleware(['auth','XSS']);

Route::post('/{slug}/projects/{id}/bug_comment/{tid}/file/{cid?}',['as' => 'bug.comment.store.file','uses' =>'ProjectController@bugStoreFile']);
Route::delete('/{slug}/projects/{id}/bug_comment/{tid}/file/{fid}',['as' => 'bug.comment.destroy.file','uses' =>'ProjectController@bugDestroyFile']);
Route::post('/{slug}/projects/{id}/bug_comment/{tid}/{cid?}',['as' => 'bug.comment.store','uses' =>'ProjectController@bugCommentStore']);
Route::delete('/{slug}/projects/{id}/bug_comment/{tid}/{cid}',['as' => 'bug.comment.destroy','uses' =>'ProjectController@bugCommentDestroy']);

Route::get('/{slug}/invoices/preview/{template}/{color}',['as' => 'invoice.preview','uses' =>'InvoiceController@previewInvoice']);
Route::resource('/{slug}/invoices','InvoiceController')->middleware(['CheckPlan']);
Route::get('/{slug}/invoices/{id}/item',['as' => 'invoice.item.create','uses' =>'InvoiceController@create_item']);
Route::post('/{slug}/invoices/{id}/item',['as' => 'invoice.item.store','uses' =>'InvoiceController@store_item']);
Route::delete('/{slug}/invoices/{id}/item/{iid}',['as' => 'invoice.item.destroy','uses' =>'InvoiceController@destroy_item']);
Route::get('/{slug}/invoices/{id}/print',['as' => 'invoice.print','uses' =>'InvoiceController@printInvoice']);

Route::get('/{slug}/taxes',['as' => 'tax.create','uses' =>'WorkspaceController@create_tax'])->middleware(['auth','XSS']);
Route::post('/{slug}/taxes',['as' => 'tax.store','uses' =>'WorkspaceController@store_tax'])->middleware(['auth','XSS']);
Route::get('/{slug}/taxes/{id}/edit',['as' => 'tax.edit','uses' =>'WorkspaceController@edit_tax'])->middleware(['auth','XSS']);
Route::post('/{slug}/taxes/{id}/update',['as' => 'tax.update','uses' =>'WorkspaceController@update_tax'])->middleware(['auth','XSS']);
Route::delete('/{slug}/taxes/{id}',['as' => 'tax.destroy','uses' =>'WorkspaceController@destroy_tax'])->middleware(['auth','XSS']);

Route::post('/{slug}/stages',['as' => 'stages.store','uses' =>'WorkspaceController@store_stages'])->middleware(['auth','XSS']);
Route::post('/{slug}/bug/stages',['as' => 'bug.stages.store','uses' =>'WorkspaceController@store_bug_stages'])->middleware(['auth','XSS']);


Route::post('/{slug}/manual-invoice-payment/{invoice_id}',['as' => 'manual.invoice.payment','uses' =>'InvoiceController@addManualPayment'])->middleware(['auth','XSS']);

Route::post('/plan-pay-with-paypal',['as' => 'plan.pay.with.paypal','uses' =>'PaypalController@planPayWithPaypal'])->middleware(['auth','XSS']);
Route::get('/{id}/plan-get-payment-status',['as' => 'plan.get.payment.status','uses' =>'PaypalController@planGetPaymentStatus'])->middleware(['auth','XSS']);



Route::get('plan_request', 'PlanRequestController@index')->name('plan_request.index')->middleware(['auth','XSS',]);
Route::get('request_frequency/{id}', 'PlanRequestController@requestView')->name('request.view')->middleware(['auth','XSS',]);
Route::get('request_send/{id}', 'PlanRequestController@userRequest')->name('send.request')->middleware(['auth','XSS',]);
Route::get('request_response/{id}/{response}', 'PlanRequestController@acceptRequest')->name('response.request')->middleware(['auth','XSS',]);
Route::get('request_cancel/{id}', 'PlanRequestController@cancelRequest')->name('request.cancel')->middleware(['auth','XSS',]);





Route::get('/{slug}/timesheet/{id}',['as' => 'projects.timesheet.index','uses' =>'ProjectController@projectsTimesheet'])->middleware(['auth','CheckPlan','XSS']);

Route::get('/{slug}/timesheet-table-view', 'ProjectController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(['auth', 'XSS']);

Route::get('/{slug}/append-timesheet-task-html', 'ProjectController@appendTimesheetTaskHTML')->name('append.timesheet.task.html')->middleware(['auth', 'XSS']);

Route::get('/{slug}/timesheet/create/{project_id}',['as' => 'project.timesheet.create','uses' =>'ProjectController@projectTimesheetCreate'])->middleware(['auth','XSS']);

Route::post('/{slug}/timesheet/store/{project_id}',['as' => 'project.timesheet.store','uses' =>'ProjectController@projectTimesheetStore'])->middleware(['auth','XSS']);

Route::get('/{slug}/timesheet/{timesheet_id}/edit/{project_id}',['as' => 'project.timesheet.edit','uses' =>'ProjectController@projectTimesheetEdit'])->middleware(['auth','XSS']);

Route::post('/{slug}/timesheet/{timesheet_id}/update/{project_id}',['as' => 'project.timesheet.update','uses' =>'ProjectController@projectTimesheetUpdate'])->middleware(['auth','XSS']);

Route::get('/{slug}/checkuserexists', 'UserController@checkUserExists')->name('user.exists')->middleware(['auth', 'XSS']);

Route::delete('/lang/{lang}',['as' => 'lang.destroy','uses' =>'WorkspaceController@destroyLang'])->middleware(['auth','XSS']);

Route::get('/stripe-payment-status',['as' => 'stripe.payment.status','uses' =>'StripePaymentController@planGetStripePaymentStatus']);
Route::post('/webhook-stripe',['as' => 'webhook.stripe','uses' =>'StripePaymentController@webhookStripe']);

Route::get('/take-a-plan-trial/{plan_id}', ['as' => 'take.a.plan.trial','uses' => 'PlanController@takeAPlanTrial'])->middleware(['auth','XSS']);
Route::get('/change-user-plan/{plan_id}', ['as' => 'change.user.plan','uses' => 'PlanController@changeUserPlan'])->middleware(['auth','XSS']);

Route::get('user/{id}/plan/{pid}/{duration}', 'UserController@manuallyActivatePlan')->name('manually.activate.plan')->middleware(['auth','XSS',]);



//================================= Plan Payment Gateways Route ====================================//

Route::post('/plan-pay-with-paystack',['as' => 'plan.pay.with.paystack','uses' =>'PaystackPaymentController@planPayWithPaystack'])->middleware(['auth','XSS']);
Route::get('/plan/paystack/{pay_id}/{plan_id}', ['as' => 'plan.paystack','uses' => 'PaystackPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-flaterwave',['as' => 'plan.pay.with.flaterwave','uses' =>'FlutterwavePaymentController@planPayWithFlutterwave'])->middleware(['auth','XSS']);
Route::get('/plan/flaterwave/{txref}/{plan_id}', ['as' => 'plan.flaterwave','uses' => 'FlutterwavePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-razorpay',['as' => 'plan.pay.with.razorpay','uses' =>'RazorpayPaymentController@planPayWithRazorpay'])->middleware(['auth','XSS']);
Route::get('/plan/razorpay/{txref}/{plan_id}', ['as' => 'plan.razorpay','uses' => 'RazorpayPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-paytm',['as' => 'plan.pay.with.paytm','uses' =>'PaytmPaymentController@planPayWithPaytm'])->middleware(['auth','XSS']);
Route::post('/plan/paytm/{plan}', ['as' => 'plan.paytm','uses' => 'PaytmPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mercado',['as' => 'plan.pay.with.mercado','uses' =>'MercadoPaymentController@planPayWithMercado'])->middleware(['auth','XSS']);
Route::get('/plan/mercado/{plan}', ['as' => 'plan.mercado','uses' => 'MercadoPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mollie',['as' => 'plan.pay.with.mollie','uses' =>'MolliePaymentController@planPayWithMollie'])->middleware(['auth','XSS']);
Route::get('/plan/mollie/{plan}', ['as' => 'plan.mollie','uses' => 'MolliePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-skrill',['as' => 'plan.pay.with.skrill','uses' =>'SkrillPaymentController@planPayWithSkrill'])->middleware(['auth','XSS']);
Route::get('/plan/skrill/{plan}', ['as' => 'plan.skrill','uses' => 'SkrillPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-coingate',['as' => 'plan.pay.with.coingate','uses' =>'CoingatePaymentController@planPayWithCoingate'])->middleware(['auth','XSS']);
Route::get('/plan/coingate/{plan}', ['as' => 'plan.coingate','uses' => 'CoingatePaymentController@getPaymentStatus']);

//================================= End Plan Payment Gateways Route ====================================//


//================================= Custom Landing Page ====================================//

//--------------------------------------------------------Import/Export Data Route-----------------------------------------------------------------


Route::get('import/user/file', 'UserController@importFile')->name('user.file.import');
Route::post('/import/user', 'UserController@import')->name('user.import');
Route::get('export/user', 'UserController@export')->name('user.export');



Route::get('/{slug}/import/client/file', 'ClientController@importFile')->name('client.file.import');
Route::post('import/client', 'ClientController@import')->name('client.import');
Route::get('export/client', 'ClientController@export')->name('client.export');

Route::get('/{slug}/import/project/file', 'ProjectController@importFile')->name('project.file.import');
Route::post('import/project', 'ProjectController@import')->name('project.import');
Route::get('export/project', 'ProjectController@export')->name('project.export');

Route::get('export/invoice', 'InvoiceController@export')->name('invoice.export');


////------------------------tracker-----------------------------------------////

Route::get('/{slug}/projects/time-tracker/{id}','ProjectController@tracker')->name('projecttime.tracker')->middleware(['auth','XSS']);
Route::get('/{slug}/projectsss/time-tracker/{id}','ProjectController@tracker')->name('client.projecttime.tracker')->middleware(['auth:client','XSS']);
Route::delete('tracker/{tid}/destroy', 'TimeTrackerController@Destroy')->name('tracker.destroy');
Route::get('/{slug}/time-tracker','TimeTrackerController@index')->name('time.tracker')->middleware(['auth','XSS']);
Route::post('/{slug}/tracker/image-view', ['as' => 'tracker.image.view','uses' => 'TimeTrackerController@getTrackerImages']);
Route::any('tracker/image-remove', ['as' => 'tracker.image.remove','uses' => 'TimeTrackerController@removeTrackerImages']);


// ================================= Zoom Meeting ======================================//


Route::get('/{slug}/zoom-meeting',['as' => 'zoom-meeting.index','uses' =>'ZoomMeetingController@index'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/create',['as' => 'zoom-meeting.create','uses' =>'ZoomMeetingController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/calendar',['as' => 'zoommeeting.Calender','uses' =>'ZoomMeetingController@calender'])->middleware(['auth','XSS']);
Route::get('/{slug}/Zoom-Meeting/calendar',['as' => 'zoommeetings.Calender','uses' =>'ZoomMeetingController@calender'])->middleware(['auth:client','XSS']);

Route::post('/{slug}/zoom-meeting/store',['as' => 'zoom-meeting.store','uses' =>'ZoomMeetingController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/{id}/show',['as' => 'zoom_meeting.show','uses' =>'ZoomMeetingController@show'])->middleware(['auth','XSS']);

Route::get('/{slug}/zoom-meetings/{id}/show',['as' => 'zoom_meetings.show','uses' =>'ZoomMeetingController@show'])->middleware(['auth:client','XSS']);

Route::get('/{slug}/zoom-meeting/{id}/edit',['as' => 'zoom-meeting.edit','uses' =>'ZoomMeetingController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/zoom-meeting/{id}/update',['as' => 'zoom-meeting.update','uses' =>'ZoomMeetingController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/zoom-meeting/{id}',['as' => 'zoom-meeting.destroy','uses' =>'ZoomMeetingController@destroy'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/members',['as' => 'projects.members','uses' =>'ProjectController@members'])->middleware(['auth','XSS']);


//=================================== slack=============================================================//

Route::post('/workspace/{slug}/settingsss',['as' => 'workspace.settings.Slack','uses' =>'WorkspaceController@settingsSlack'])->middleware(['auth','XSS']);


// ====================================telegram===============================================================//

Route::post('/workspace/{slug}/telegram',['as' => 'workspace.settings.telegram','uses' =>'WorkspaceController@settingstelegram'])->middleware(['auth','XSS']);

/*==================================Recaptcha====================================================*/

Route::post('/recaptcha-settings',['as' => 'recaptcha.settings.store','uses' =>'SettingsController@recaptchaSettingStore'])->middleware(['auth','XSS']);

/*==============================================Invoice Paymentwall===========================================================*/
Route::any('{slug}/paymentwall/invoice/{invoice_id}', ['as' => 'paymentwall.index', 'uses' => 'PaymentWallPaymentController@invoiceindex']);
Route::post('{slug}/invoice-pay-with-paymentwall/{invoice_id}', ['as' => 'invoice.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@invoicePayWithPaymentwall']);
Route::any('{slug}/invoice/error/{flag}/{invoice_id}', 'PaymentWallPaymentController@orderpaymenterror')->name('invoice.callback.error');

/*================================================client password reset======================================================*/
Route::get('{slug}/client/resetpassword/{id}',['as' => 'client.reset.password','uses' =>'ClientController@resetPassword'])->middleware(['auth','XSS']);
Route::post('{slug}/client/changepassword/{id}',['as' => 'client.change.password','uses' =>'ClientController@changePassword'])->middleware(['auth','XSS']);

/*================================================Email Templates======================================================*/

Route::get('email_template_lang/{id}/{lang?}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language')->middleware(['auth']);
Route::post('email_template_store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language')->middleware(['auth']);
Route::any('{slug}/email_template_status/{id}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);

Route::resource('email_template', 'EmailTemplateController')->middleware(['auth']);
Route::resource('email_template_lang', 'EmailTemplateLangController')->middleware(['auth','XSS']);
// End Email Templates



////**===================================== Project Reports =======================================================////

Route::resource('/{slug}/project_report','ProjectReportController')->middleware(['auth','XSS']);
Route::post('/{slug}/project_report_data','ProjectReportController@ajax_data')->name('projects.ajax')->middleware(['auth','XSS']);
Route::post('/{slug}/project_report/{id}','ProjectReportController@show')->name('project_report.show')->middleware(['auth','XSS']);

Route::post('/{slug}/project_report/tasks/{id}',['as' => 'tasks.report.ajaxdata','uses' =>'ProjectReportController@ajax_tasks_report'])->middleware(['auth','XSS']);

Route::get('export/task_report/{id}', 'ProjectReportController@export')->name('project_report.export');


// End Project Reports




//////****================================== Contract Module ===========================================******///////
Route::resource('/{slug}/contract_type', 'ContractsTypeController')->middleware(['auth','XSS']);

Route::resource('/{slug}/contracts', 'ContractController')->middleware(['auth','XSS']);

Route::get('get-projects/{client_id}', 'ContractController@clientByProject')->name('project.by.user.id')->middleware(['auth','XSS']);


Route::get('/{slug}/contract/{id}',['as' => 'contracts.copy','uses' =>'ContractController@copycontract'])->middleware(['auth','XSS']);
Route::post('/{slug}/contract/copy/store/{id}',['as' => 'contracts.copy.store','uses' =>'ContractController@copycontractstore'])->middleware(['auth','XSS']);


Route::post('/{slug}/contract/{id}/contract_description', 'ContractController@contract_descriptionStore')->name('contract.contract_description.store')->middleware(['auth']);
Route::post('/{slug}/contract/{id}/file', ['as' => 'contracts.file.upload','uses' => 'ContractController@fileUpload',])->middleware(['auth','XSS']);

Route::get('/{slug}/contract/{id}/file/{fid}', ['as' => 'contracts.file.download','uses' => 'ContractController@fileDownload',])->middleware(['auth','XSS']);
Route::delete('/{slug}/contract/{id}/file/delete', ['as' => 'contracts.file.delete','uses' => 'ContractController@fileDelete',])->middleware(['auth','XSS']);

Route::post('/{slug}/contract/{id}/comment', ['as' => 'comment_store.store', 'uses' => 'ContractController@commentStore',])->middleware(['auth']);
Route::get('/{slug}/contract/{id}/comment', ['as' => 'comment_store.destroy','uses' => 'ContractController@commentDestroy',]);
Route::post('/{slug}/contract/{id}/notes', ['as' => 'note_store.store', 'uses' => 'ContractController@noteStore',])->middleware(['auth']);
Route::get('/{slug}/contract/{id}/notes', ['as' => 'note_store.destroy','uses' => 'ContractController@noteDestroy',])->middleware(['auth']);

Route::get('/{slug}/contract/{id}/mail', ['as' => 'send.mail.contract','uses' => 'ContractController@sendmailContract',]);
Route::get('/{slug}/contract/pdf/{id}', 'ContractController@pdffromcontract')->name('contract.download.pdf');
Route::get('/{slug}/contract/{id}/get_contract', 'ContractController@printContract')->name('get.contract');


Route::get('/{slug}/signature/{id}', 'ContractController@signature')->name('signature')->middleware(['auth','XSS']);
Route::post('/{slug}/signaturestore', 'ContractController@signatureStore')->name('signaturestore')->middleware(['auth','XSS']);


///////*************End Contract Module ==================================================================================////



