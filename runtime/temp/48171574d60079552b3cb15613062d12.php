<?php /*a:1:{s:66:"E:\webwww\tp5.1-advanced\application\backend\view\login\index.html";i:1542956632;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/static/images/favico.png">
    <title><?php echo config('app_name'); ?></title>
    <link rel="stylesheet" href="/static/css/ace.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/element-ui/2.4.7/theme-chalk/fonts/element-icons.ttf">
    <link rel="stylesheet" href="https://cdn.staticfile.org/element-ui/2.4.7/theme-chalk/index.css">
    <link rel="stylesheet" href="/static/css/app.css?v=20181009">

</head>
<body style="background-color: #f0f2f5;">
<div class="flex flex-column" style="height: 100%;">
    <div class="login-header">
        <div class="home-header" style="height: 60px;">
            <div class="">
                <img src="/static/images/logo.png" alt="">
            </div>
        </div>
    </div>
    <div id="app-login" class="login-home" style="flex: 1 0 auto;">
        <div class="app-content">
            <div class="login-bg">
                <div class="login-wrap absolute-Center" v-loading="loging">

                    <h3>用户登录</h3>

                    <el-form :model="login_form" :rules="rules" ref="ruleForm" label-width="40px" class="login-form">
                        <el-form-item prop="name">
                            <el-input placeholder="账号" v-model="login_form.login_user">
                                <template slot="prefix"><img src="/static/images/login/user.png"></template>
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="name">
                            <el-input placeholder="密码" type="password" v-model="login_form.login_pwd">
                                <template slot="prefix"><img src="/static/images/login/pass.png"></template>
                            </el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="login()" style="width: 300px; margin: 10px auto">登录</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
    <div class="login-footer">
        <div class="home-footer">
            <div class="copyright">tp5.1_advanced ©版权所有2018</div>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/vue/2.5.17/vue.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.staticfile.org/vue/2.5.17/vue.js"></script>-->
<script type="text/javascript" src="https://cdn.staticfile.org/element-ui/2.4.7/index.js"></script>

<script type="text/javascript">
    var vueBox = new Vue({
        el: '#app-login',
        data: {
            login_form: {
                login_user: '',
                login_pwd: '',
                remember_me: true
            },
            loging: false,
            rules:[]
        },
        methods: {
            login: function () {
                var _self = this;
                _self.loging = true;

                $.ajax({
                    type: 'POST',
                    url: "/api/loginCheck",
                    data: _self.login_form,
                    dataType: 'json',
                    success:function (result) {
                        console.info(result.Code);
                        if(result.Code === '0'){
                            _self.$message.success(result.Msg);
                            window.location.href = '/admin/home';
                        }else{
                            _self.$message({
                                message: result.Msg,
                                type: 'warning'
                            });
                            _self.loging = false;
                            return false;
                        }
                    }
                });
            }
        }
    });
</script>



</body>
</html>