<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Routing\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CodeController extends Controller
{
    protected $title = '';
    public $html;

    public function __construct()
    {
        $this->html = '';
//        Admin::style('.form-control {margin-top: 10px;}');
//        Admin::script('console.log("hello world");');
//        Admin::css('/your/css/path/style.css');
//        Admin::js('/your/javascript/path/js.js');
    }

    public function index(Content $content)
    {
        $img = $this->qrcode();
//        $size = 200;
//        $url = 'http://www.baidu.com';
//
//        //图一：二维码中间小图
//        $logo = 'https://img2.baidu.com/it/u=2725122823,1083212123&fm=26&fmt=auto';
//        //图二：二维码背景图
//        $bg = 'https://img2.baidu.com/it/u=2725122823,1083212123&fm=26&fmt=auto';
//        //合并二维码中间的小图之后，微信扫码识别不出来，可能是中间的小图要非常小才行
////        $gen = QrCode::format('png')->size($size)->merge($logo, .3, true)->generate($url);
//        $gen = QrCode::format('png')->size($size)->generate($url);
//        $img = 'data:image/png;base64,' . base64_encode($gen);

        $data = [
            'img' => $img,
        ];
        $content = $content
            ->row(function (Row $row) use ($data) {
                $row->column(12, function (Column $column) use ($data) {
                    $column->append(view('admin::code', [
                        'img' => $data['img'],
                    ]));
                });
            });
        return $content;
    }

    //生成二维码
    public function qrcode()
    {
        $file = DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "qrcode" . DIRECTORY_SEPARATOR;
        if (!file_exists(public_path($file))) {
            mkdir(public_path($file), 0777, true);
        }
        $recuid = Admin::user()->id;
        $path = $file . DIRECTORY_SEPARATOR . $recuid . ".png";
        $img = 'static/images/code_bg.png';
        $url = "https://www.baidu.com?uid=" . $recuid; //扫描二维码要跳转的地址
        QrCode::format('png')->errorCorrection('L')
            ->size(200)->generate($url, public_path($path));
        $qrcode['path'] = $path;
        // 图片合成
        $bg = imagecreatefrompng($img);// 提前准备好的海报图  必须是PNG格式
        $qrcodes = imagecreatefrompng(public_path($path)); //二维码
        imagecopyresampled($bg, $qrcodes, 80, 350, 0, 0, imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes));
        imagepng($bg, public_path($path)); //合并图片
        return $path;
    }

}
