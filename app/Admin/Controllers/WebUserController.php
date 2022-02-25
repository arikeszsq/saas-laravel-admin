<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Traits\UserTrait;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebUserController extends AdminController
{
    use UserTrait;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '平台用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminUser());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        if (static::isSuperAdmin()) {
            $grid->disableCreateButton();//禁用创建按钮
        } else {
            $web_id = static::webId();
            $grid->model()->where('web_id', $web_id);
        }
        $grid->column('id', __('ID'));
        $grid->column('username', __('用户名'));
        $grid->column('name', __('名称'));
        $grid->column('created_at', __('创建时间'));
        $grid->actions(function ($actions) {
            $actions->disableView();    // 去掉查看
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdminUser());
        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->text('username', __('用户名'))->required();
        $form->text('name', __('名称'))->required();
        $form->password('password', trans('admin.password'))->rules('confirmed|required');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });
        $form->ignore(['password_confirmation']);
        $form->saving(function (Form $form) {
            $user_name = $form->username;
            $admin_exsit = AdminUser::query()->where('username', $user_name)->first();
            if ($admin_exsit) {
                admin_error('用户名已存在，请换一个新的用户名');
                return redirect('/admin/webs');
            }
            $password = Hash::make($form->password);
            $form->password = $password;
            if ($form->isCreating()) {
                $form->model()->created_at = date('Y-m-d H:i:s');
                $form->model()->updated_at = date('Y-m-d H:i:s');
                $form->model()->admin_role_id = 3;
                $form->model()->web_id = static::webId();
                $form->model()->is_web_super = 2;
                $form->model()->web_name = static::user()->web_name;
            } else {
                $form->model()->updated_at = date('Y-m-d H:i:s');
            }
        });
        //保存后回调
        $form->saved(function (Form $form) {
            $user_id = $form->model()->id;
            DB::table('admin_role_users')->insert(['role_id' => 3, 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s', time())]);
        });
        return $form;
    }

}
