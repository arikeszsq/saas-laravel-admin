<?php

use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('articles', 'ArticleController');
    $router->resource('manage', 'ManageController');
    $router->resource('analysis', 'AnalysisController');

    /** 进件选择栏目列表 **/
    $router->resource('user-code-options', UserCodeOptionController::class);
    /** 进件 **/
    $router->resource('add-user-codes', AddUserCodeController::class);
    /** 客户 **/
    $router->resource('users', UserController::class);

    /** 站点管理 **/
    $router->resource('webs', WebController::class);

    /** 站点平台用户 **/
    $router->resource('web-users', WebUserController::class);


    $router->resource('user-logs', UserLogController::class);
    $router->resource('areas', AreaController::class);
    $router->resource('codes', CodeController::class);
    $router->resource('company', CompanyController::class);


});
