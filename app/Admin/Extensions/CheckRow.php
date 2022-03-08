<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class CheckRow
{
    protected $row;
    protected $mobile;

    public function __construct($row)
    {
        $this->row = $row;
        $this->mobile = $row['mobile'];
    }

    protected function script()
    {
        return <<<SCRIPT
    //初始化设备
    var callout_cb;
    init();

    function init() {
        getWebsocket();
    }

$('.call_mobile').on('click', function () {
     var mobile = $(this).data('id');
     if (!mobile) {
            alert('请先选择需要拨打的用户号码');
        } else {
            console.log('开始拨号：'+mobile);
            Call(mobile);
        }
});

$('.hang_mobile').on('click', function () {
     hangup();
});

function Call(number) {
        if (!ws) {
            alert("控件未初始化");
            return false;
        }
        callout_cb = 'CallOut_cb_' + new Date().getTime();
        var action = {
            action: 'CallOut',
            number: number,
            cb: callout_cb
        };
        ws.send(JSON.stringify(action));
        ws.onmessage = function (event) {
            console.log('Check_row_on_Message',event.data);
        };
        //发生错误
        ws.onerror = function () {
            console.log("error");
        }
    }

    function getWebsocket() {
        ws = new WebSocket('ws://127.0.0.1:8090/APP_2AD85C71-BEF8-463C-9B4B-B672F603542A_fast');
        ws.onerror = function (event) {
            alert('初始化设备失败：' + event.data);
        };
        ws.onclose = function (event) {
        };
        ws.onopen = function () {
            console.log('初始化设备成功');
        }
    }

    function hangup() {
        ws.send(JSON.stringify({action: 'Hangup', cb: new Date().getTime()}));
        ws.onmessage = function (event) {
            console.log("message", event.data);
        };
        ws.onerror = function () {
            console.log("error");
        }
    }

     function uploadFile() {
        ws.send(
            JSON.stringify({
                action: 'Settings',
                settings: {
                    upload: {
                        api: 'http://tk.lianshuiweb.com/api/upload-file',
                        flag: 'token-1234-123',
                        file: '1'
                    }
                },
                cb: new Date().getTime()
            })
        );
    }
SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
//        Admin::js('/static/js/app.js');

        return "<a class='btn btn-xs btn-success call_mobile' data-id='{$this->mobile}'><i class=\"fa fa-phone\" aria-hidden=\"true\"></i>拨号</a>
<a class='btn btn-xs btn-danger hang_mobile' data-id='{$this->mobile}'>挂机</a>";

    }

    public function __toString()
    {
        return $this->render();
    }
}
