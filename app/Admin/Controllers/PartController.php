<?php

namespace App\Admin\Controllers;

use App\Models\Part;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PartController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Part';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Part());

        if (!self::isSuperAdmin()) {
            $grid->model()->where('web_id', static::webId());
            if (!self::isWebAdmin()) {
                $grid->model()->where('user_id', static::userId());
            }
        }

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();

        $grid->column('name', __('部门名称'));
        $grid->column('part_user_id', __('部门负责人'));

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
        $show = new Show(Part::findOrFail($id));

        $show->field('name', __('部门名称'));
        $show->field('part_user_id', __('部门负责人'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Part());

        $form->text('name', __('部门名称'));
        $form->text('part_user_id', __('部门负责人'));

        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->web_id = Admin::user()->web_id;
                $form->model()->user_id = Admin::user()->id;
            }
        });
        return $form;
    }
}
