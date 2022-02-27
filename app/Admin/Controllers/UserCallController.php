<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserExcel;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class UserCallController extends Controller
{
    public $title = '';

    public function index(Content $content)
    {
        $users = UserExcel::query()->get();

        return $content->title('详情')
            ->description('简介')
            ->view('user.call', $users->toArray());
    }
}
