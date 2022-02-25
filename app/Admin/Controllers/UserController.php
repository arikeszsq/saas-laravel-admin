<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchAssign;
use App\Admin\Actions\Post\ImportPost;
use App\Admin\Extensions\CheckRow;
use App\Admin\Extensions\Options;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
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
        $grid = new Grid(new User());
        $grid->quickSearch('user_name');

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportPost());
        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                $filter->like('company_name', '企业名称');
                $filter->like('user_name', '联系人');
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('mobile', '手机号');
            });
        });

        $grid->model()->where('web_id', static::webId());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('company_name', __('企业名称'));
        $grid->column('user_name', __('联系人'));
        $grid->column('mobile', __('手机号'));
        $grid->column('link_url', __('进件二维码'))->qrcode();
//        $grid->column('created_at', __('添加时间'));
        $grid->column('bak', __('备注'))->editable('textarea');

        $grid->actions(function ($actions) {
            $actions->disableDelete();// 去掉删除
//            $actions->append('<a href=""><i class="fa fa-eye">生成专属进件码</i></a>');// 添加操作
            $actions->append(new CheckRow($actions->getKey()));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('web_id', __('Web id'));
        $show->field('company_name', __('Company name'));
        $show->field('user_name', __('User name'));
        $show->field('mobile', __('Mobile'));
        $show->field('id_card', __('Id card'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_tax_no', __('Company tax no'));
        $show->field('money_need', __('Money need'));
        $show->field('legal_name', __('Legal name'));
        $show->field('legal_id_card', __('Legal id card'));
        $show->field('legal_mobile', __('Legal mobile'));
        $show->field('legal_bank_no', __('Legal bank no'));
        $show->field('bank', __('Bank'));
        $show->field('legal_company', __('Legal company'));
        $show->field('legal_house', __('Legal house'));
        $show->field('edu', __('Edu'));
        $show->field('marry', __('Marry'));
        $show->field('marry_name', __('Marry name'));
        $show->field('marry_mobile', __('Marry mobile'));
        $show->field('marry_id_card', __('Marry id card'));
        $show->field('marry_work_detail', __('Marry work detail'));
        $show->field('pre_mobile', __('Pre mobile'));
        $show->field('relation_o', __('Relation o'));
        $show->field('relation_mob_o', __('Relation mob o'));
        $show->field('relation_t', __('Relation t'));
        $show->field('relation_mob_t', __('Relation mob t'));
        $show->field('cert_pic', __('Cert pic'));
        $show->field('id_card_pic', __('Id card pic'));

        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->tab('基础信息', function ($form) {
            $form->divider('基础信息');
            $form->text('company_name', __('企业名称'))->attribute('maxlength', 100)
                ->style('width', '50%');
            $form->text('user_name', __('联系人'))->style('width', '50%');
            $form->mobile('mobile', __('手机号'))->style('width', '50%');
            $form->text('id_card', __('身份证号码'))->style('width', '50%');
            $form->text('company_tax_no', __('企业税号'));
            $form->text('money_need', __('资金缺口'));
            $form->select('edu', __('学历'))->options(Options::getEdu());
//            $form->image('id_card_pic', __('身份证图片'))->removable();
            $form->multipleImage('id_card_pic', __('身份证图片'))->removable();//用mysql的JSON类型字段存储
        });

        $form->tab('法人信息', function ($form) {
            $form->divider('法人信息');
            $form->text('legal_name', __('法人姓名'));
            $form->text('legal_id_card', __('法人身份证号码'));
            $form->text('legal_mobile', __('法人手机号码（本人实名）'));
            $form->text('legal_bank_no', __('法人名下银行卡（四大行）'));
            $form->text('bank', __('开户行（支行信息）'));
            $form->text('legal_company', __('法人公司地址'));
            $form->text('legal_house', __('法人居住地址'));
            $form->multipleImage('cert_pic', __('营业执照'))->removable();
        });

        $form->tab('婚姻状况', function ($form) {
            $form->divider('婚姻状况');
            $form->select('marry', __('婚姻状况'))->options(Options::getMarryCondition());
            $form->text('marry_name', __('配偶姓名'));
            $form->text('marry_mobile', __('配偶手机号'));
            $form->text('marry_id_card', __('配偶身份证号码'));
            $form->text('marry_work_detail', __('配偶工作地址'));
            $form->text('pre_mobile', __('预留手机号'));
        });

        $form->tab('紧急联系人', function ($form) {
            $form->divider('联系人');
            $form->text('relation_o', __('紧急联系人1 姓名'))->style('width', '50%');
            $form->mobile('relation_mob_o', __('紧急联系人1 电话号码'))->style('width', '50%');
            $form->text('relation_t', __('紧急联系人2 姓名'))->style('width', '50%');
            $form->mobile('relation_mob_t', __('紧急联系人2 电话号码'))->style('width', '50%');
        });

        return $form;
    }
}
