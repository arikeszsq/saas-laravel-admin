<?php

namespace App\Admin\Controllers;

use App\Models\UserIntention;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserIntentionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserIntention';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserIntention());

        $grid->column('id', __('Id'));
        $grid->column('web_id', __('Web id'));
        $grid->column('user_id', __('User id'));
        $grid->column('master_Id', __('Master Id'));
        $grid->column('company_name', __('Company name'));
        $grid->column('user_name', __('User name'));
        $grid->column('mobile', __('Mobile'));
        $grid->column('wechat', __('Wechat'));
        $grid->column('qq', __('Qq'));
        $grid->column('type', __('Type'));
        $grid->column('status', __('Status'));
        $grid->column('bak', __('Bak'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(UserIntention::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('web_id', __('Web id'));
        $show->field('user_id', __('User id'));
        $show->field('master_Id', __('Master Id'));
        $show->field('company_name', __('Company name'));
        $show->field('user_name', __('User name'));
        $show->field('mobile', __('Mobile'));
        $show->field('wechat', __('Wechat'));
        $show->field('qq', __('Qq'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
        $show->field('bak', __('Bak'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserIntention());

        $form->number('web_id', __('Web id'));
        $form->number('user_id', __('User id'));
        $form->number('master_Id', __('Master Id'));
        $form->text('company_name', __('Company name'));
        $form->text('user_name', __('User name'));
        $form->mobile('mobile', __('Mobile'));
        $form->text('wechat', __('Wechat'));
        $form->text('qq', __('Qq'));
        $form->number('type', __('Type'));
        $form->number('status', __('Status'));
        $form->textarea('bak', __('Bak'));

        return $form;
    }
}
