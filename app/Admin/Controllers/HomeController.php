<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public $title = '';

    public function index(Content $content)
    {
        $content->row(function (Row $row) {
            $row->column(12, function (Column $column) {
                $html ='<H1 style="margin: 100px auto;text-align: center;color: #3c8dbc;">欢迎来到管理后台</H1>';
                $column->append($html);
            });

        });
        return $content;

//            $content->row(function (Row $row) {
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
//            });
    }
}
