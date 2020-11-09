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

Auth::routes();

// Home section
Route::get('/', 'Pages\HomeController@index')->name('home');

// Features section
Route::get('/features', 'Pages\FeaturesController@index')->name('features');

// Pricing section
Route::get('/pricing', 'Pages\PricingController@index')->name('pricing');

// FAQ section
Route::get('/faq', 'Pages\FAQController@index')->name('faq');

// Contacts sections
Route::get('/contacts', 'Pages\ContactController@index')->name('contacts');
Route::post('/contacts/create', 'Pages\ContactController@store')->name('contacts.create');

// This link will add session of language when they click to change language
Route::get('/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

/*
|--------------------------------------------------------------------------
| Adminlte
|--------------------------------------------------------------------------
*/

// Role - Admin
Route::group(['middleware' => ['role:admin']], function()
{
    // Dashboard section
    Route::get('/admin/dashboard', 'Adminlte\admin\DashboardAdminController@index');

    // Users sections
    Route::get('/admin/users', 'Adminlte\admin\UsersAdminController@index');

    // Team Members sections
    Route::get('/admin/team/members', 'Adminlte\admin\team\MembersController@index');
    Route::get('/admin/add-role', 'Adminlte\admin\team\privileges\roles\RoleController@index');
    Route::post('/admin/add-role', 'Adminlte\admin\team\privileges\roles\RoleController@store');
    Route::get('/admin/assign-role', 'Adminlte\admin\team\privileges\roles\RoleAssignmentController@index');
    Route::post('/admin/assign-role', 'Adminlte\admin\team\privileges\roles\RoleAssignmentController@store');
    Route::get('/admin/add-permission', 'Adminlte\admin\team\privileges\permissions\PermissionController@index');
    Route::post('/admin/add-permission', 'Adminlte\admin\team\privileges\permissions\PermissionController@store');
    Route::get('/admin/assign-permission', 'Adminlte\admin\team\privileges\permissions\PermissionAssignmentController@index');
    Route::post('/admin/assign-permission', 'Adminlte\admin\team\privileges\permissions\PermissionAssignmentController@store');

    // Tickets section
    Route::get('/admin/tickets', 'Adminlte\admin\TicketController@index');

    // Settings section
    Route::get('/admin/settings', 'Adminlte\admin\SettingsAdminController@index');

    Route::get('/admin/{locale}', function ($locale) {
        App::setLocale(Session::put('locale', $locale));
        return redirect()->back();
    });
});

// Role - User Admin (free)
Route::group(['middleware' => ['role:userFree|userPro']], function()
{
    // Dashboard section
    Route::get('/user/dashboard', 'Adminlte\ZabbixController@historyGet')->name('admin.user_admin.index');

    // Monitoring sections
    Route::get('/user/monitoring/monitors/add', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsController@create');
    Route::post('/user/monitoring/monitors/add', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsController@store');
    Route::get('/user/monitoring/monitors/list', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsController@history');
    Route::get('/user/monitoring/uptime', 'Adminlte\user_admin\monitoring\MonitoringUptimeController@index');
    Route::get('/user/monitoring/page-speed', 'Adminlte\user_admin\monitoring\MonitoringPageSpeedController@index');
    Route::get('/user/monitoring/real-user-monitoring', 'Adminlte\user_admin\monitoring\MonitoringRealUserMonitoringController@index');

    // Alerts sections
    Route::get('/user/alerts', 'Adminlte\user_admin\AlertsController@index');

    // Settings section
    Route::get('/user/settings', 'Adminlte\user_admin\SettingController@index');

    // Support section
    Route::get('/user/support', 'Adminlte\user_admin\SupportController@index');

    Route::get('/user/{locale}', function ($locale) {
        App::setLocale(Session::put('locale', $locale));
        return redirect()->back();
    });
});
