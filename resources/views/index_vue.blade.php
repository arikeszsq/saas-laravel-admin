<html>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>信息采集</title>
    <script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/static/vue/vant/index.css"/>
    <script src="/static/vue/vue.js"></script>
    <script src="/static/vue/axios/axios.min.js"></script>
    <script src="/static/vue/vant/vant.min.js"></script>
</head>
<body>
<style>
    body {
        background-color: #c1ecfa;
    }

    .banner{
        height: 200px;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    .banner img {
        width: 100%;
        align-items: center;
    }
    .form-class{
        margin-top: 10px;
    }
</style>
<div id="app">
    <input type="hidden" name="id" value="123">
    <div class="banner">
        <img :src="image_url">
    </div>

    <input type="hidden" id="user_id" value="{{$user_id}}">
    <input type="hidden" id="image_url" value="{{$image_url}}">

    <div class="form-class" style="width: 96%; margin-left: 2%;">
        <van-form @submit="onSubmit">
            <van-field v-model="company" name="公司名称" label="公司名称" placeholder="公司名称"
                       :rules="[{ required: true, message: '请填写公司名称' }]"></van-field>
            <van-field v-model="username" name="联系人" label="联系人" placeholder="联系人"
                       :rules="[{ required: true, message: '请填写联系人' }]"></van-field>
            <van-field v-model="mobile" name="手机号码" label="手机号码" placeholder="手机号码"
                       :rules="[{required: true, message: '请输入手机号码', trigger: 'change'},
                   {validator: checkPhone, message: '手机号格式错误'}]"></van-field>
            <van-field v-model="id_card" name="身份证号码" label="身份证号码" placeholder="身份证号码"
                       :rules="[
                   { required: true, message: '请填写身份证号码', trigger: 'blur' },
                   {pattern: /(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/, message: '证件号码格式有误！', trigger: 'blur'}
                   ]"></van-field>
            <div style="margin: 16px;">
                <van-button round block type="info" native-type="submit">提交</van-button>
            </div>
        </van-form>
    </div>

</div>
<script>
    var user_id = $('#user_id').val();
    var image_url = $('#image_url').val();
    new Vue({
        el: '#app',
        data() {
            return {
                image_url: image_url,
                company: '',
                username: '',
                mobile: '',
                id_card: '',
                user_id:user_id
            };
        },
        methods: {
            onSubmit(values) {
                console.log('submit', values);

                var baseUrl = '/api/add';
                var that = this;
                axios.get(baseUrl, {
                    params: {
                        user_id: that.user_id,
                        company: that.company,
                        username: that.username,
                        mobile: that.mobile,
                        id_card: that.id_card,
                    }
                }).then(function (res) {
                    console.log(res)
                    that.$toast("asdfasdf");
                });
            },
            checkPhone(value) {
                return /1\d{10}/.test(value);
            },
            // initPage: function () {
            //     var baseUrl = '/api/add';
            //     var that = this;
            //     axios.get(baseUrl, {
            //         params: {
            //             user_id:that.user_id
            //         }
            //     }).then(function (res) {
            //         console.log(res)
            //     });
            // },


        },
        // mounted: function () {
        //     var that = this;
        //     that.initPage();
        // }

    });
</script>
</body>

</html>
