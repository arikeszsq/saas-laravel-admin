<html>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>拓客</title>
    <script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/webuploader/webuploader.css">
    <script type="text/javascript" src="/static/webuploader/webuploader.js"></script>

    <link rel="stylesheet" href="/static/css/update.css">
</head>
<body>
<style>
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

    .notice {
        font-size: 10px;
        color: darkgrey;
    }

    .submit-div {
        margin-top: 20px;
        text-align: center;
    }
    .uploader-demo{
        margin: 10px auto;
    }
</style>

<div class="banner">
    <img src="https://img2.baidu.com/it/u=578470490,2014202223&fm=253&fmt=auto&app=138&f=JPEG?w=658&h=260" alt="">
</div>


<div class="form-submit" style="width: 96%;margin-left: 2%;">
    <form id="form">
        <input type="hidden" name="id" value="{{$id}}">
        <div class="input-group">
            <label class="need">公司名称</label>
            <input type="text" name="company_name" placeholder="请输入公司名称" aria-describedby="basic-addon1"
                   value="{{$company_name}}" readonly>
        </div>
        <div class="input-group">
            <label class="need">企业税号</label>
            <input type="text" name="company_tax_no" placeholder="请输入企业税号" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <label class="need">资金缺口</label>
            <input type="text" name="money_need" placeholder="请输入资金缺口" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <label class="need">法人姓名</label>
            <input type="text" name="legal_name" placeholder="请输入法人姓名" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">法人身份证号码</label>
            <input type="text" name="legal_id_card" placeholder="请输入法人身份证号码" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">法人手机号码（本人实名）</label>
            <input type="text" name="legal_mobile" placeholder="请输入法人手机号码（本人实名）" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">法人名下银行卡（四大行）</label>
            <input type="text" name="legal_bank_no" placeholder="请输入法人名下银行卡（四大行）" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">开户行（支行信息）</label>
            <input type="text" name="bank" placeholder="请输入开户行（支行信息）" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">法人公司地址</label>
            <input type="text" name="legal_company" placeholder="请输入法人公司地址" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">法人居住地址</label>
            <input type="text" name="legal_house" placeholder="请输入法人居住地址" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">学历</label>
            <input type="text" name="edu" placeholder="请输入学历" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">婚姻状况</label>
            <input type="text" name="marry" placeholder="请输入婚姻状况" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">配偶姓名</label>
            <input type="text" name="marry_name" placeholder="请输入配偶姓名" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">配偶手机号</label>
            <input type="text" name="marry_mobile" placeholder="请输入配偶手机号" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">配偶身份证号码</label>
            <input type="text" name="marry_id_card" placeholder="请输入配偶身份证号码" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">配偶工作地址</label>
            <input type="text" name="marry_work_detail" placeholder="请输入配偶工作地址" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">预留手机号</label>
            <input type="text" name="pre_mobile" placeholder="请输入预留手机号" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <label class="need">紧急联系人1</label>
            <input type="text" name="relation_o" placeholder="关系" aria-describedby="basic-addon1">
            <input type="text" name="relation_mob_o" placeholder="手机号码" aria-describedby="basic-addon1" style="margin-top: 5px;">
        </div>

        <div class="input-group">
            <label class="need">紧急联系人2</label>
            <input type="text" name="relation_t" placeholder="关系" aria-describedby="basic-addon1">
            <input type="text" name="relation_mob_t" placeholder="手机号码" aria-describedby="basic-addon1" style="margin-top: 5px;">
        </div>


        <div id="uploader-demo">
            <label>营业执照:</label>
            <div id="fileList"></div>
            <div id="filePicker">上传营业执照</div>
            <p class="notice">(支持gif,jpg,jpeg,bmp,png,大小不超过10M)</p>
        </div>
        <div id="uploader-demo">
            <label>上传身份证图片（正反面）:</label>
            <div id="fileList_id"></div>
            <div id="filePicker_id">上传身份证</div>
            <p class="notice">(支持gif,jpg,jpeg,bmp,png,大小不超过10M)</p>
        </div>
        <div class="submit-div">
            <button class="btn btn-info submit">提交</button>
        </div>
    </form>

</div>

<script>

    $('form').submit(function (event) {
        event.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'post',
            url: '/api/update',
            data: form.serialize(),
            success: function (res) {
                if (res.msg_code == 100000) {
                    window.location.href = '/result';
                } else {
                    alert(res.message)
                }
            }
        });
    });

    // $('.submit').on('click', function () {
    //     // var cert = '';
    //     // var id_card = '';
    //     // $(".cert_array").each(function (i, el) {
    //     //     if (i <= 0) {
    //     //         cert += ($(this).val());
    //     //     } else {
    //     //         cert += ',' + ($(this).val());
    //     //     }
    //     // });
    //     // $(".id_card_array").each(function (i, el) {
    //     //     if (i <= 0) {
    //     //         id_card += ($(this).val());
    //     //     } else {
    //     //         id_card += ',' + ($(this).val());
    //     //     }
    //     // });
    // });

    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/static/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '/api/upload',
        // 后台接收的name
        fileVal: 'file',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        fileNumLimit: 300,
        fileSizeLimit: 100 * 1024 * 1024,
        fileSingleSizeLimit: 10 * 1024 * 1024,
    });

    var $list = $('#fileList'), ratio = 1 || 1,
        // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio;

    // 当有文件添加进来的时候
    uploader.on('fileQueued', function (file) {
        var $list = $('#fileList');
        var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
            '<p class="imgWrap"><img></p>' +
            '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
            $img = $li.find('img');
        var $btns = $('<div class="file-panel">' +
            '<span class="cancel btn btn-xs btn-danger" style="color: white;">删除</span>').appendTo($li);
        $li.on('mouseenter', function () {
            $btns.stop().animate({height: 30});
        });
        $li.on('mouseleave', function () {
            $btns.stop().animate({height: 0});
        });
        $list.append($li);
        $btns.on('click', 'span', function () {
            var index = $(this).index();
            switch (index) {
                case 0:
                    uploader.removeFile(file);
                    removeFile(file);
                    removeCertFile(file);
                    return;
            }
        });
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
        }, thumbnailWidth, thumbnailHeight);
    });

    // 文件上传失败，显示上传出错。
    uploader.on('error', function (file) {
        alert('不支持的文件格式和大小');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, response) {
        var file_id = file.id;
        var url = response._raw;
        var html = '<input type="hidden" name="cert_pic[]" class="cert_array cert_' + file_id + '" value="' + url + '">';
        $(html).insertAfter($('#fileList'));
    });

    var uploader_id = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/static/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '/api/upload',
        // 后台接收的name
        fileVal: 'file',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker_id',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    // 当有文件添加进来的时候
    uploader_id.on('fileQueued', function (file) {
        var $list = $('#fileList_id');
        var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
            '<p class="imgWrap"><img></p>' +
            '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
            $img = $li.find('img');
        var $btns = $('<div class="file-panel">' +
            '<span class="cancel btn btn-xs btn-danger" style="color: white;">删除</span>').appendTo($li);
        $li.on('mouseenter', function () {
            $btns.stop().animate({height: 30});
        });
        $li.on('mouseleave', function () {
            $btns.stop().animate({height: 0});
        });
        $list.append($li);
        $btns.on('click', 'span', function () {
            var index = $(this).index();
            switch (index) {
                case 0:
                    uploader_id.removeFile(file);
                    removeFile(file);
                    removeIdCardFile(file);
                    return;
            }
        });
        uploader_id.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
        }, thumbnailWidth, thumbnailHeight);
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader_id.on('uploadSuccess', function (file, response) {
        var file_id = file.id;
        var url = response._raw;
        var html = '<input type="hidden" name="id_card_pic[]" class="id_card_array idcard_' + file_id + '" value="' + url + '">';
        $('#fileList_id').append(html);
    });

    function removeCertFile(file) {
        var file_id = file.id;
        var class_id = 'cert_' + file_id;
        $('.' + class_id).remove();
    }

    function removeIdCardFile(file) {
        var file_id = file.id;
        var class_id = 'idcard_' + file_id;
        $('.' + class_id).remove();
    }

    // 负责view的销毁
    function removeFile(file) {
        var $li = $('#' + file.id);
        $li.off().find('.file-panel').off().end().remove();
    }

</script>
</body>
