<?php

namespace App\Admin\Controllers;

use App\Models\AddUserCode;
use App\Models\AdminUser;
use App\Models\Qcode;
use App\Models\UserCodeOption;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AddUserCodeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '进件码';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AddUserCode());
        $grid->model()->where('user_id', static::userId());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', 'ID')->sortable();
        $grid->column('title', __('名称'));
        $grid->column('qcode_pic', __('进件二维码'))->image();
        $grid->column('created_at', __('创建时间'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(AddUserCode::findOrFail($id));
        $show->panel()
            ->style('danger');
        $show->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });

        $show->field('user_id', __('创建人'))->as(function ($user_id) {
            $admin = AdminUser::query()->where('id', $user_id)->first();
            return $admin->name;
        });

        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $options = UserCodeOption::query()->where('web_id', static::webId())
            ->orderBy('id', 'desc')->get();
        $directors = [];
        foreach ($options as $option) {
            $directors[$option->id] = $option->title;
        }
        $form = new Form(new AddUserCode());
        $form->select('option_id', '模板')->options($directors)->required();
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->web_id = Admin::user()->web_id;
                $form->model()->user_id = Admin::user()->id;
            }
        });
        $form->saved(function (Form $form) {
            $id = $form->model()->id;
            $web_id = $form->model()->web_id;
            $url = env('APP_URL') . '?web_id=' . $web_id . '&id=' . $id;
            $form->model()->qcode_pic = Qcode::qrcode($url);
            $form->model()->scan_to_url = $url;
            $option = UserCodeOption::query()->find($form->model()->option_id);
            $form->model()->title = $option->title;
            $form->model()->save();
        });
        return $form;
    }
}
