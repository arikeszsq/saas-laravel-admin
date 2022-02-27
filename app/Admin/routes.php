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



    /** 拓客选择栏目列表 **/
    $router->resource('user-code-options', UserCodeOptionController::class);
    /** 拓客 **/
    $router->resource('add-user-codes', AddUserCodeController::class);
    /** 拓客客户列表 **/
    $router->resource('user-ks', UserTKController::class);

    /** 客户 **/
    $router->resource('users', UserController::class);

    /** 站点管理 **/
    $router->resource('webs', WebController::class);

    /** 站点平台用户 **/
    $router->resource('web-users', WebUserController::class);


    /** 资源库，基础用户数据 **/
    $router->resource('user-excels', UserExcelController::class);
    /** 资源库，crm呼叫系统 **/
    $router->resource('user-call', UserCallController::class);
    /** 资源库，意向客户 **/
    $router->resource('user-intentions', UserIntentionController::class);


    $router->resource('user-logs', UserLogController::class);
    $router->resource('areas', AreaController::class);
    $router->resource('codes', CodeController::class);
    $router->resource('company', CompanyController::class);


});
