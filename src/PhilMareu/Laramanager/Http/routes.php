<?php

use Illuminate\Support\Facades\Schema;
use PhilMareu\Laramanager\Models\LaramanagerRedirect;
use PhilMareu\Laramanager\Models\LaramanagerResource;

Route::group(['namespace' => 'PhilMareu\Laramanager\Http\Controllers', 'middleware' => 'web'], function()
{
    Route::get('admin/login', 'Auth\LoginController@showLoginForm');
    Route::post('admin/login', 'Auth\LoginController@login');
    Route::post('admin/logout', 'Auth\LoginController@logout');
    Route::get('admin/password/email', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('admin/password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('admin/password/reset', 'Auth\PasswordController@reset');
    Route::get('laramanager/install', 'Auth\InstallController@showInstallForm');
    Route::post('laramanager/install', 'Auth\InstallController@processInstall');

    if(Schema::hasTable('laramanager_redirects'))
    {
        foreach(LaramanagerRedirect::all() as $redirect)
        {
            Route::get($redirect->from, 'RedirectsController@redirect');
        }
    }

    Route::get('feed/{type}', 'RssFeedsController@show');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function()
    {
        Route::get('/', 'AdminController@index');
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('images/browser', 'ImagesController@imageBrowser');
        Route::resource('images', 'ImagesController', ['except' => ['create', 'destroy']]);

        // Redirects
        Route::resource('redirects', 'RedirectsController');

        // RSS Feeds
        Route::resource('feeds', 'RssFeedsController', ['except' => ['show']]);

        // Users
        Route::resource('users', 'UsersController', ['except' => ['show']]);

        if(Schema::hasTable('laramanager_resources'))
        {
            foreach(LaramanagerResource::all() as $resource)
            {
                Route::resource($resource->slug, 'EntriesController');
            }
        }

        Route::get('{resource}/object/{resourceId}/{objects}/create', 'ResourceObjectsController@create');
        Route::post('{resource}/object/{resourceId}/{objects}', 'ResourceObjectsController@store');
        Route::get('{resource}/object/{resourceId}/{id}/edit', 'ResourceObjectsController@edit');
        Route::put('{resource}/object/{resourceId}/{id}', 'ResourceObjectsController@update');
        Route::put('{resource}/objects/reorder', 'ResourceObjectsController@reorder');
        Route::delete('{resource}/object/{id}', ['before' => 'ajax', 'uses' => 'ResourceObjectsController@destroy']);

        Route::get('resources/fields/getOptions/{type}', 'ResourceFieldController@getOptions');
        Route::get('resources/{resources}/fields/{fields}/edit', 'ResourceFieldController@edit');
        Route::put('resources/{resources}/fields/{fields}/edit', 'ResourceFieldController@update');
        Route::get('resources/{resources}/fields', 'ResourceFieldController@index');
        Route::get('resources/{resources}/fields/create', 'ResourceFieldController@create');
        Route::post('resources/{resources}/fields/create', 'ResourceFieldController@store');
        Route::delete('resources/{resources}/fields/{fields}', 'ResourceFieldController@destroy');
        Route::resource('resources', 'ResourcesController');

        Route::resource('laramanager-navigation-sections', 'NavigationSectionsController');
        Route::resource('laramanager-navigation-links', 'NavigationLinksController');
        Route::resource('objects', 'ObjectsController');
        Route::resource('field-types', 'FieldTypesController');
        Route::resource('settings', 'SettingsController');
    });
});