<?php

namespace App\Admin\Controllers;

use App\Models\AddUserCode;
use App\Models\AdminUser;
use App\Models\Qcode;
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
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', 'ID')->sortable();
        $grid->column('banner_img', __('进件网站banner'))->image();
        $grid->column('qcode_pic', __('进件二维码'))->image();
        $grid->column('body_color', __('网站颜色'));
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
//                $tools->disableEdit();
//                $tools->disableList();
                $tools->disableDelete();
            });

        $show->field('id', __('Id'));
//        $show->field('web_id', __('站点名称'));
        $show->field('banner_img', __('网站banner'))->avatar()->image();
        $show->field('body_color', __('网站body背景色'));
        $show->divider();
        $show->field('qcode_back_img', __('二维码背景图'))->avatar()->image();
        $show->field('left', __('二维码X轴位置'));
        $show->field('top', __('二维码Y轴位置'));

        $show->divider();

        $show->field('user_id', __('User id'));

        $show->field('user_id', __('创建人'))->as(function ($user_id) {
            $admin = AdminUser::query()->where('id', $user_id)->first();
            return $admin->name;
        });

//        $show->author('创建人', function ($author) {
//            $author->name();
//        });

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
        $form = new Form(new AddUserCode());
        $form->image('banner_img', __('进件网站banner'));
        $form->image('qcode_back_img', __('二维码背景图'));
        $form->number('left', __('二维码X轴位置'));
        $form->number('top', __('二维码Y轴位置'));
        $form->text('body_color', __('网站背景色'));
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
            $img = $form->model()->qcode_back_img;
            $x = $form->model()->left;
            $y = $form->model()->top;
            $form->model()->qcode_pic = Qcode::qrcode($url, $img, $x, $y);
            $form->model()->scan_to_url = $url;
            $form->model()->save();
        });
        return $form;
    }
}
