<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CheckRow;
use App\Models\UserIntention;
use App\Traits\ResponseTrait;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
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
    protected $title = '意向客户';

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

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();

        $grid->column('company_name', __('公司名称'));
        $grid->column('user_name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('type', __('类型'));
        $grid->column('bak', __('备注'))->editable();
        $grid->column('created_at', __('添加时间'));

        $grid->actions(function ($actions) {
//            var_dump($actions->row);exit;
            $actions->disableDelete();// 去掉删除
            $actions->append(new CheckRow($actions->row,'jf_user_intention'));
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
        $show = new Show(UserIntention::findOrFail($id));

        $show->field('company_name', __('公司名称'));
        $show->field('user_name', __('姓名'));
        $show->field('mobile', __('手机号'));
        $show->field('wechat', __('微信'));
        $show->field('qq', __('QQ'));
        $show->field('type', __('类型'));
        $show->field('bak', __('备注'));
        $show->field('created_at', __('添加时间'));
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
        $form = new Form(new UserIntention());

        $form->text('company_name', __('公司名称'));
        $form->text('user_name', __('姓名'));
        $form->mobile('mobile', __('手机号'));
        $form->text('wechat', __('微信'));
        $form->text('qq', __('QQ'));
        $form->select('type', __('类型'))->options([
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
        ]);
        $form->textarea('bak', __('备注'));

        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->web_id = Admin::user()->web_id;
                $form->model()->user_id = Admin::user()->id;
                $form->model()->master_id = Admin::user()->id;
            }
        });
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
