<?php

namespace App\Admin\Controllers;

use App\Models\Articles;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '<p style="background-color: red;">hello</p>
<p>hello</p><p>hello</p>';

    public $type_list = [
        1 => '资讯新闻',
        2 => '学习中心',
        3 => '关于我们'
    ];

    public $status_list = [
        1 => '已发布',
        2 => '已删除',
        3 => '草稿'
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Articles());

        $grid->column('id', __('Id'));
        $grid->column('type', __('类型'))->display(function ($type) {
            $type_list = [
                1 => '资讯新闻',
                2 => '学习中心',
                3 => '关于我们'
            ];
            return $type_list[$type];
        });
        $grid->column('description', __('描述'));
        $grid->column('title', __('名称'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $status_list = [
                1 => '已发布',
                2 => '已删除',
                3 => '草稿'
            ];
            return $status_list[$status];
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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
        $show = new Show(Articles::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('类型'))->using($this->type_list);
        $show->field('description', __('描述'));
        $show->field('banner', __('banner图片'))->image();
        $show->field('title', __('名称'));
        $show->field('content', __('内容'));
        $show->field('creator_id', __('作者ID'));
        $show->field('status', __('状态'))->using($this->status_list);
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
        $show->field('deleted_at', __('删除时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Articles());

        $form->select('type', '类型')->options($this->type_list)->default('1');
        $form->text('title', __('名称'));
        $form->textarea('description', __('描述'));
        $form->image('banner', __('banner图片'));
        $form->UEditor('content', __('内容'));
        $form->select('status', __('状态'))->options($this->status_list)->default('1');
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->creator_id = Admin::user()->id;
            }
        });
        return $form;
    }
}
