<?php

namespace App\Admin\Controllers;

use App\Models\UserTK;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserTKController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserTK';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserTK());
        $grid->quickSearch('user_name');
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('company_name', '企业名称');
                $filter->like('user_name', '联系人');
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->like('mobile', '手机号');
            });
        });

        $grid->model()->where('web_id', static::webId());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('company_name', __('企业名称'));
        $grid->column('user_name', __('联系人'));
        $grid->column('mobile', __('手机号'));
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
        $show = new Show(UserTK::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('company_name', __('企业名称'));
        $show->field('user_name', __('联系人'));
        $show->field('mobile', __('手机号'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
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
        $form = new Form(new UserTK());

        $form->text('company_name', __('企业名称'));
        $form->text('user_name', __('联系人'));
        $form->mobile('mobile', __('手机号'));
        $form->textarea('bak', __('备注'));

        return $form;
    }
}
