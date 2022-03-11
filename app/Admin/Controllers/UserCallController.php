<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserExcel;
use App\Models\UserIntention;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use zgldh\QiniuStorage\QiniuStorage;


class UserCallController extends Controller
{
    public $title = '';

    public function index(Content $content)
    {
        $web_id = static::webId();
        $user_id = static::userId();
        $users = UserExcel::query()
            ->where('web_id',$web_id)
            ->where('master_id',$user_id)
            ->where('call_no', 0)
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

        $data = [];
        foreach ($users as $key => $user) {
            $data[] = [
                'key_id' => ($key + 1),
                'id' => $user->id,
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'mobile' => $user->mobile,
                'call_no' => $user->call_no,
                'company_name' => $user->company_name,
            ];
        }
//        return $content->title('详情')
//            ->description('简介')
//            ->view('user.call', ['users' => $users->toArray()]);
        return $content->title('详情')
            ->description('简介')
            ->view('user.call', ['users' => $data]);
    }


    public function upload(Request $request)
    {
        $disk = QiniuStorage::disk('qiniu');
        $file_url = '/static/images/code_bg.png';
        $online_url = 'test.png';
        $bool = $disk->put($online_url, file_get_contents($file_url));
        if ($bool) {
            $path = $disk->downloadUrl($online_url);
            return '上传成功，url:' . $path;
        }
        return '上传失败';
    }


}
