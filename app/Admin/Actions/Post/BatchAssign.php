<?php

namespace App\Admin\Actions\Post;

use App\Models\AdminUser;
use App\Models\UserExcel;
use App\Traits\UserTrait;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BatchAssign extends BatchAction
{
    use UserTrait;
    public $name = '批量分配';

    public function handle(Collection $collection, Request $request)
    {
        $admin_id = $request->get('admin_id');
        $key = $request->get('_key');
        $id_array = explode(',', $key);
        UserExcel::query()->whereIn('id', $id_array)->update([
            'master_id' => $admin_id
        ]);

        return $this->response()->success('Success')->refresh();
    }

    public function form()
    {
        $users = AdminUser::query()->where('web_id', static::webId())
            ->orderBy('id', 'desc')
            ->get();
        $options = [];
        foreach ($users as $user) {
            $options[$user->id] = $user->username;
        }
        $this->select('admin_id', '用户')->options($options);

    }

}
