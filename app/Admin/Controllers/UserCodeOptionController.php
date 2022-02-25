<?php

namespace App\Admin\Controllers;

use App\Models\UserCodeOption;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserCodeOptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserCodeOption());
        $grid->model()->where('web_id', static::webId());
        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('名称'));
        $grid->column('banner', __('轮播图'))->image();
        $grid->column('bak', __('备注'));
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
        $show = new Show(UserCodeOption::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('名称'));
        $show->field('banner', __('轮播图'))->avatar()->image();
        $show->field('bak', __('备注'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserCodeOption());

        $form->text('title', __('名称'))->required();
        $form->image('banner', __('轮播图'))->required();
        $form->textarea('bak', __('备注'));
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->web_id = static::webId();
                $form->model()->user_id = static::userId();
                $form->model()->created_at = date('Y-m-d H:i:s');
                $form->model()->updated_at = date('Y-m-d H:i:s');
            } else {
                $form->model()->updated_at = date('Y-m-d H:i:s');
            }
        });
        return $form;
    }
}
