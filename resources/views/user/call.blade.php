<html>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>拓客</title>
    <script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/call/call.css">
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-01 clearfix">
    <div class="right list_item user-info-list">
        <li class="li_title"><span>公司名词</span><span>用户名</span><span>手机号</span></li>
        <ul>
            @foreach ($users as $k => $val)
                <li class="user-info"
                    data-id={{ $val['id'] }}
                        data-user_id={{ $val['user_id'] }}
                        data-user_name={{ $val['user_name'] }}
                        data-mobile={{ $val['mobile'] }}
                        data-call_no={{ $val['call_no'] }}
                        data-company_name={{ $val['company_name'] }}
                >
                    <span> {{ $val['company_name']}}</span>
                    <span> {{ $val['user_name']}}</span>
                    <span> {{ $val['mobile']}}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="container_zong left">
        <form class="container_sss">
            <div class="form-item">
                <input type="text" class="txt form-company-name" placeholder="企业名称"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-user-name" placeholder="联系人"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-mobile" placeholder="手机号"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-wechat" placeholder="请输入微信号"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-qq" placeholder="请输入QQ号"/>
            </div>
            <div class="form-item clearfix">
                <div class="left title">客户类别</div>
                <div class="left">
                    <label><input type="radio" name="sex" checked/><span>A</span></label><label>
                        <input type="radio" name="sex"/><span>B</span></label><label><input
                            type="radio" name="sex"/><span>C</span></label><label><input type="radio" name="sex"/><span>D</span></label>
                </div>
            </div>
            <div class="form-item"><textarea class="txt" placeholder="请填写备注"></textarea></div>
        </form>
        <div class="button-list">
            <button id="batch_call" class="btn btn-success">开始自动拨号</button>
            <button id="batch_hangup" class="btn btn-danger">停止自动拨号</button>
            <button id="call" class="btn btn-info">拨号</button>
            <button id="hangup" class="btn btn-danger">挂断</button>
            <button id="set_intention_user" class="btn btn-primary">转为意向客户</button>
        </div>
    </div>
</div>
<script>
    //初始化设备
    var callout_cb;
    init();

    function init() {
        getWebsocket();
    }

    //点击右侧列表，把信息传到表单
    $('.user-info').click(function () {
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        var company_name = $(this).data('company_name');
        var user_name = $(this).data('user_name');
        var mobile = $(this).data('mobile');
        var call_no = $(this).data('call_no');
        $('.form-company-name').val(company_name);
        $('.form-user-name').val(user_name);
        $('.form-mobile').val(mobile);
    });

    //单独拨号
    $('#call').click(function () {
        var mobile = $('.form-mobile').val();
        if (!mobile) {
            alert('请先选择需要拨打的用户号码');
        } else {
            Call(mobile);
        }
    });

    //单独挂机
    $('#hangup').click(function () {
        hangup()
    });


    //
    // $('#batch_call').click(function () {
    //     $(".user-info-list ul li").each(function (key, item) {
    //         var mobile = $(item).data('mobile');
    //         // Call(mobile);
    //         //30秒后自动挂机
    //         setTimeout("hangup()",30000 );
    //     })
    // });

    //主动切换下一张卡拨号
    $('#next').click(function () {
        ws.send(JSON.stringify({action: 'SimNext', cb: new Date().getTime()}));
        ws.onmessage = function (event) {
            console.log("message", event.data);
        };
        ws.onerror = function () {
            console.log("error");
        }
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
        //收到服务端消息
        ws.onmessage = function (event) {
            console.log("message", event.data);
            var data = JSON.parse(event.data);
            var message = data.message;
            var param = data.param;
            var status = param.status;
            if (status == 'TalkingStart') {
                console.log('语音开始');
            } else if (status == 'TalkingEnd') {
                console.log("语音结束");
                uploadFile();
            } else if (status == 'CallEnd') {
                console.log("通话结束:我个人理解为未接通或者挂机");
            }
        };
        //发生错误
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
                        api: 'https://www.test.com/upload',
                        flag: 'token-1234-123',
                        file: '1',
                        qiniu: {
                            AccessSecret: 'oQ3ZTYyikPQ_jzQ5ryohIUly4v6hZTTWP36VcaqM_self',
                            AccessKey: 'SQxedWGQY-XiP1XrEODpdgmi4kiCM9yvQJ0-mHBI_sefl',
                            Zone: 'Zone_z1',
                            Bucket: 'pdcallertest'
                        }
                    }
                },
                cb: new Date().getTime()
            })
        );
    }

    function getWebsocket() {
        ws = new WebSocket('ws://127.0.0.1:8090/APP_2AD85C71-BEF8-463C-9B4B-B672F603542A_fast');
        ws.onerror = function (event) {
            alert('初始化设备失败：' + event.data);
        };
        ws.onclose = function (event) {
        };
        ws.onopen = function () {
            alert('初始化设备成功');
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
</script>
</body>
