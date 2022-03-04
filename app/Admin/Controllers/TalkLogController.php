<?php

namespace App\Admin\Controllers;

use App\Models\TalkLog;
use App\Models\UserExcel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TalkLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TalkLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TalkLog());

        $grid->disableCreateButton();

        if (!self::isSuperAdmin()) {
            $grid->model()->where('web_id', static::webId());
            if (!self::isWebAdmin()) {
                $grid->model()->where('user_id', static::userId());
            }
        }

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('excel_user_name', '姓名');
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->like('mobile', '手机号');
            });
        });

        $grid->actions(function ($actions) {
            $actions->disableDelete();// 去掉删除
            $actions->disableEdit();    // 去掉编辑
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('excel_user_name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('talk_time', __('通话时长'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('record_url', __('录音文件'));

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
        $show = new Show(TalkLog::findOrFail($id));

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableDelete();
            });;

        $show->field('id', __('Id'));
        $show->field('excel_user_name', __('姓名'));
        $show->field('mobile', __('手机号'));
        $show->field('talk_time', __('通话时长'));
        $show->field('created_at', __('添加时间'));
        $show->field('updated_at', __('修改时间'));
        $show->field('record_url', __('录音文件地址'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TalkLog());

        $form->mobile('mobile', __('手机号'));
        $form->number('talk_time', __('通话时长'));

        return $form;
    }


    public function addUserCallRB(Request $request)
    {
        $inputs = $request->all();
        $id = $inputs['id'];
        $cdr = $inputs['cdr'];
        $user_excel = UserExcel::query()->find($id);
        $user_excel->call_no += 1;
        $user_excel->save();
        $user_id = static::userId();
        $web_id = static::webId();
//        $cdr = "[Succeeded|CallNumber:18115676166|CallTime:|TalkTime:00:00:08|Key:|ClientOnHook|CCID:89860319945125379324]";
        $cdr_array = explode('|', $this->cut('[', ']', $cdr));
        $result = $cdr_array[0];
        $mobile = 0;
        $talk_time = 0;
        foreach ($cdr_array as $v) {
            if (strpos($v, 'CallNumber') !== false) {
                $mobile = $this->toArrayCut($v, ':');
            }
            if (strpos($v, 'TalkTime') !== false) {
                $time = mb_substr($v, 9);
                $time_array = explode(':', $time);
                $talk_time = $time_array[0] * 3600 + $time_array[1] * 60 + $time_array[2];
            }
        }
        if ($mobile) {
            $data = [
                'web_id' => $web_id,
                'user_id' => $user_id,
                'excel_user_id' => $id,
                'excel_user_name' => $user_excel->user_name,
                'mobile' => $mobile,
                'talk_time' => $talk_time,
                'created_at' => date('Y-m-d H:i:s', time()),
//            'record_url' => '录音地址'
            ];
            DB::table('jf_talk_log')->insert($data);
        }
    }

    function cut($begin, $end, $str)
    {
        $b = mb_strpos($str, $begin) + mb_strlen($begin);
        $e = mb_strpos($str, $end) - $b;
        return mb_substr($str, $b, $e);
    }

    function toArrayCut($str, $string)
    {
        $array = explode($string, $str);
        if (isset($array[1]) && $array[1]) {
            return $array[1];
        } else {
            return 0;
        }
    }
}
