<?php

namespace App\Admin\Controllers;

use App\Models\UserIntention;
use App\Traits\ResponseTrait;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class UserIntentionController extends AdminController
{
    use ResponseTrait;
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

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('user_name', '姓名');
                $filter->like('company_name', '公司名称');
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->like('mobile', '手机号');
            });
        });

        if (!self::isSuperAdmin()) {
            $grid->model()->where('web_id', static::webId());
            if (!self::isWebAdmin()) {
                $grid->model()->where('user_id', static::userId());
            }
        }
        $grid->column('id', __('Id'));

        $grid->column('company_name', __('公司名称'));
        $grid->column('user_name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('wechat', __('微信'));
        $grid->column('qq', __('Qq'));
        $grid->column('type', __('类型'));
        $grid->column('created_at', __('添加时间'));
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


    public function addIntentionUser(Request $request)
    {
        $inputs = $request->all();
        $user_id = static::userId();
        $web_id = static::webId();
        $data = [
            'web_id' => $web_id,
            'user_id' => $user_id,
            'master_Id' => $user_id,
            'company_name' => isset($inputs['company_name']) && $inputs['company_name'] ? $inputs['company_name'] : '',
            'user_name' => isset($inputs['user_name']) && $inputs['user_name'] ? $inputs['user_name'] : '',
            'mobile' => isset($inputs['mobile']) && $inputs['mobile'] ? $inputs['mobile'] : '',
            'wechat' => isset($inputs['wechat']) && $inputs['wechat'] ? $inputs['wechat'] : '',
            'qq' => isset($inputs['qq']) && $inputs['qq'] ? $inputs['qq'] : '',
            'type' => isset($inputs['type']) && $inputs['type'] ? $inputs['type'] : '',
            'bak' => isset($inputs['bak']) && $inputs['bak'] ? $inputs['bak'] : '',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        try {
            $ret = UserIntention::query()->insert($data);
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }
}
