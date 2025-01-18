<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\LoansController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\ReferralsController;
use App\Http\Controllers\Admin\SettingsController;


Route::redirect('/', '/office/public/apply-loan');

Route::redirect('/home', '/admin')->name('home');

Route::get('/apply-loan', 'FrontController@applyLoan')->name('apply.loan.view');
Route::post('/apply-loan-store', 'FrontController@store')->name('apply.loan.store');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::put('users/update-profile/{id}', 'UsersController@updateProfile')->name('users.update.profile');

    Route::get('users/change-password', 'UsersController@changePassword')->name('users.change.password');

    Route::put('users/update-password', 'UsersController@updatePassword')->name('users.update.password');

    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');

                /*----Customer----*/

    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');

    Route::resource('customers', 'CustomersController');

                /*----Contact----*/

    Route::delete('contacts/destroy', 'ContactsController@massDestroy')->name('contacts.massDestroy');

    Route::resource('contacts', 'ContactsController');

                 /*----Loan----*/

    Route::delete('loans/destroy', 'LoansController@massDestroy')->name('loans.massDestroy');

    Route::resource('loans', 'LoansController');

                /*----Notification----*/

    Route::delete('notifications/destroy', 'NotificationsController@massDestroy')->name('notifications.massDestroy');

    Route::resource('notifications', 'NotificationsController');

                 /*----Referral----*/

    Route::delete('referrals/destroy', 'ReferralsController@massDestroy')->name('referrals.massDestroy');

    Route::resource('referrals', 'ReferralsController');

                /*----Setting----*/

    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');

    Route::resource('settings', 'SettingsController');

    Route::post('import', 'ContactsController@import')->name('import');

    Route::resource('channels', 'ChannelsController');
    Route::resource('lead-makers', 'LeadMakersController');
    Route::resource('payment-transfer', 'PaymentTransferController');
    Route::get('lead-makers/tree-view/{id}', 'LeadMakersController@treeView')->name('lead-makers.tree-view');
    Route::get('lead-makers/convert/{id}', 'LeadMakersController@convert')->name('lead-makers.convert');


});
