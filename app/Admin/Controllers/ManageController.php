<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\Articles;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;


class ManageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'admin_users';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminUser());

        $grid->column('id', __('Id'));

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
        $form->text('username', __('登录名'));
        $form->text('password', __('密码'));
        $form->image('avatar', __('头像'));
        $form->text('name', __('姓名'));

        $form->saving(function (Form $form) {
            $form->password = bcrypt($form->password);
//            if ($form->isCreating()) {
//                $form->model()->creator_id = Admin::user()->id;
//            }
        });
        return $form;
    }

}
