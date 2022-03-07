<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchAssign;
use App\Admin\Actions\Post\ImportPost;
use App\Admin\Extensions\CheckRow;
use App\Models\UserExcel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserExcelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserExcel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserExcel());

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportPost());
        });

        if (!self::isSuperAdmin()) {
            $grid->model()->where('web_id', static::webId());
            if (!self::isWebAdmin()) {
                $grid->model()->where('master_id', static::userId());
            }
        }

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

        $grid->column('id', __('Id'))->sortable();
        $grid->column('company_name', __('公司名称'));
        $grid->column('user_name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('created_at', __('添加时间'));

        $grid->actions(function ($actions) {
//            var_dump($actions->row);exit;
            $actions->disableDelete();// 去掉删除
            $actions->append(new CheckRow($actions->row));
        });

        $grid->batchActions(function ($batch) {
            $batch->add(new BatchAssign());
        });
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
        $show = new Show(UserExcel::findOrFail($id));
        $show->field('company_name', __('公司名称'));
        $show->field('user_name', __('姓名'));
        $show->field('mobile', __('手机号'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserExcel());

        $form->text('company_name', __('公司名称'));
        $form->text('user_name', __('姓名'));
        $form->mobile('mobile', __('手机号'));
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->web_id = self::webId();
                $form->model()->user_id = self::userId();
                $form->model()->master_id = self::userId();
            }
        });

        return $form;
    }
}
