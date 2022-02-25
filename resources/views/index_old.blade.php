<html>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>拓客</title>
    <script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/static/css/index.css">
</head>
<body>
<style>

    body {
        background-color: {{$color}};
    }

    .input-group {
        margin-top: 20px;
    }

    .banner {
        height: 220px;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .banner img {
        width: 100%;
        align-items: center;
    }

    .input-group {
        width: 100%;
    }

    .need::before {
        margin-right: 3px;
        padding-top: 2px;
        color: red;
        content: '*';
    }

    input {
        width: 100%;
        border: 0;
        outline: none;
        background-color: rgba(0, 0, 0, 0);
        font-size: 12px;
        height: 40px;
        border-radius: 4px;
        border-bottom: 1px solid #c8cccf;
        color: #986655;
        outline: 0;
        text-align: left;
        padding-left: 10px;
        display: block;
        cursor: pointer;
        box-shadow: 2px 2px 5px 1px #ccc;
    }

    input::-webkit-input-placeholder {
        color: #986655;
        font-size: 12px;
    }

    .submit-button {
        margin-top: 20px;
        text-align: center;
    }

    .notice {
        color: red;
    }

</style>

<div class="banner">
    <img src="{{$image}}" alt="">
</div>

<div class="form-submit" style="width: 96%;margin-left: 2%;">
    <input type="hidden" id="web_id" value="{{$web_id}}">
    <div class="input-group">
        <label class="need">公司名称</label>
        <input type="text" class="company_name" placeholder="请输入公司名称" aria-describedby="basic-addon1">
        <span class="notice"></span>
    </div>
    <div class="input-group">
        <label class="need">联系人</label>
        <input type="text" class="username" placeholder="请输入联系人" aria-describedby="basic-addon1">
        <span class="notice"></span>
    </div>
    <div class="input-group">
        <label class="need">联系电话</label>
        <input type="text" class="mobile" placeholder="请输入联系电话" aria-describedby="basic-addon1">
        <span class="notice"></span>
    </div>
    <div class="input-group">
        <label class="need">身份证号码</label>
        <input type="text" class="id_card" placeholder="请输入身份证号码" aria-describedby="basic-addon1">
        <span class="notice"></span>
    </div>
    <div class="submit-button">
        <button class="btn btn-info submit">提交</button>
    </div>
</div>

<script>

    $('.submit').click(function () {
        var company_name = $('.company_name').val();
        var user_name = $('.username').val();
        var mobile = $('.mobile').val();
        var id_card = $('.id_card').val();

        var error = 0;
        if (!company_name) {
            $(".company_name").parent().find('.notice').html("请输入公司名称！");
            $(".company_name").focus();
            error++;
        } else {
            $(".company_name").parent().find('.notice').html("");
        }
        if (!user_name) {
            $(".username").parent().find('.notice').html("请输入联系人！");
            $(".username").focus();
            error++;
        } else {
            $(".username").parent().find('.notice').html("");
        }
        if (!(/^1[23456789]\d{9}$/.test(mobile))) {
            $(".mobile").parent().find('.notice').html("请输入合法手机号！");
            $(".mobile").focus();
            error++;
        } else {
            $(".mobile").parent().find('.notice').html("");
        }

        var regIdNo = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if (!regIdNo.test(id_card)) {
            $(".id_card").parent().find('.notice').html("请输入合法身份证号码！");
            $(".id_card").focus();
            error++;
        } else {
            $(".id_card").parent().find('.notice').html("");
        }

        if (error > 0) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/api/add',
            data: {
                'web_id': $('#web_id').val(),
                'company_name': company_name,
                'user_name': user_name,
                'mobile': mobile,
                'id_card': id_card,
            },
            success: function (res) {
                if (res.msg_code == 100000) {
                    window.location.href = '/result';
                } else {
                    alert(res.message)
                }
            }
        });
    })
</script>
</body>
