<?php /*a:2:{s:70:"E:\webwww\tp5.1-advanced\application\backend\view\auth\group_edit.html";i:1543469670;s:59:"E:\webwww\tp5.1-advanced\application\backend\view\base.html";i:1542945489;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/static/images/favico.png">
    <title><?php echo htmlentities($curr_menu['title']); ?>-<?php echo htmlentities($curr_parent_menu['title']); ?>-<?php echo config('app_name'); ?></title>
    <!--<link rel="stylesheet" href="/static/css/ace.min.css">-->
    <link rel="stylesheet" href="https://cdn.staticfile.org/normalize/8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/basscss/8.0.4/css/basscss.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/colors/3.0.0/css/colors.min.css">
    <link rel="application/x-font-ttf" href="https://cdn.staticfile.org/element-ui/2.4.9/theme-chalk/fonts/element-icons.ttf">
    <link rel="stylesheet" href="https://cdn.staticfile.org/element-ui/2.4.9/theme-chalk/index.css">
    <link rel="stylesheet" href="/static/css/app.css?v=20181119">
    <style>
        [v-cloak] {
            display: none;
        }
        .el-submenu__title {
            height: 44px !important;
            line-height: 40px !important;
        }
        .el-submenu .el-menu-item {
            height: 44px !important;
            line-height: 44px !important;
            background-color: #f9fafc !important;
            padding-left: 54px !important;
        }
        .el-table .cell {
            font-size: 14px !important;
        }
        .el-submenu [class^=el-icon-] {
            height: 24px;
        }
        .el-submenu__title:hover {
            color: #318ff5 !important;
            background-color: #f5f7fa !important;
        }
        .el-table--border {
            border-left: 0 none;
            border-top: 0 none;
        }
        .el-table::before {
            height: 0;
            display: none;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <el-container style="height: 100%;">
        <!--<div id="">-->
            <el-header height="60px" id="header-wrap">
                <div class="left mt2">
                    <a href="/admin/home" class="">
                        <img src="/static/images/logo.png" alt="">
                    </a>
                </div>
                <div class="right mt2">
                    <el-dropdown>
                    <span class="el-dropdown-link login-username">
                    <?php echo htmlentities($user['username']); ?><i class="el-icon-arrow-down el-icon--right"></i>
                    </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item>
                                <el-button type="text" @click="window.location.href='/api/logout'">退出</el-button>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>
            </el-header>
        <!--</div>-->
        <el-container>
            <el-aside width="200px">
                <div id="menu-wrap">
                    <el-menu
                            default-active="<?php echo htmlentities($curr_menu['pid']); ?>-<?php echo htmlentities($curr_menu['highlight']); ?>"
                            class="el-menu-vertical-demo"
                            background-color="#fff"
                            text-color="#5d5d61"
                            style="overflow: hidden"
                            unique-opened
                            active-text-color="#318ff5">
                        <?php foreach($menuList as $key=>$val): if(isset($val['id'])): ?>
                            <el-submenu index="<?php echo htmlentities($val['id']); ?>" :id="'menu-title-' + <?php echo htmlentities($val['id']); ?>">
                                <template slot="title">
                                    <i class="el-icon-all" style="background: url(/static/images/<?php echo htmlentities($val['icon']); ?>.png) no-repeat center center;"></i>
                                    <span><?php echo htmlentities($val['title']); ?></span>
                                </template>
                                <?php foreach($val['subMenu'] as $k=>$v): if($v['is_menu']==1): ?>
                                    <a href="<?php echo htmlentities($v['rule']); ?>"><el-menu-item index="<?php echo htmlentities($val['id']); ?>-<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['title']); ?></el-menu-item></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </el-submenu>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </el-menu>
                </div>
            </el-aside>
            <el-main id="main-wrap" >
                <div id="">
                    
                    <?php if($curr_menu['title'] !== '首页'): ?>
                    <div style="margin-bottom: 20px;">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item><a href="/admin/home">首页</a></el-breadcrumb-item>
                            <el-breadcrumb-item><a href="#"><?php echo htmlentities($curr_parent_menu['title']); ?></a></el-breadcrumb-item>
                            <el-breadcrumb-item><a href="#"><?php echo htmlentities($curr_menu['title']); ?></a></el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>
                    <?php endif; ?>
                    <div id="content-wrap text-center">
                        
 

<el-card class="box-card">
    <div slot="header" class="clearfix">
        <span v-show="id!=0">编辑角色</span>
        <span v-else>添加角色</span>
    </div>

    <div class="text item text-center">
        <template>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" size="mini" class="demo-ruleForm">
                        <el-form-item label="角色名称" prop="title">
                            <el-input v-model="ruleForm.title" placeholder="角色名称"></el-input>
                        </el-form-item>
                        <el-form-item label="备注" prop="remark">
                            <el-input type="textarea" v-model="ruleForm.remark" placeholder="备注"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button size="mini" type="primary" @click="submitForm('ruleForm')" :disabled="isDisabled">提交</el-button>
                            <el-button size="mini" @click="javascript:history.go(-1);location.replace(document.referrer);">返回</el-button>
                        </el-form-item>
                    </el-form>

                </el-col>
            </el-row>
        </template>
    </div>


</el-card>


                    </div>
                </div>
            </el-main>
        </el-container>
    </el-container>
</div>



<script type="text/javascript" src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/vue/2.5.17/vue.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.staticfile.org/vue/2.5.17/vue.js"></script>-->
<script type="text/javascript" src="https://cdn.staticfile.org/element-ui/2.4.9/index.js"></script>
<script type="text/javascript" src="/static/js/moment-with-locales.min.js?v=20181009"></script>
<script type="text/javascript" src="/static/js/app.js?v=20181009"></script>
<script type="text/javascript" src="/static/js/store.js?v=20181013"></script>
<script type="text/javascript" src="/static/js/filters.js?v=20181013"></script>



<script type="text/javascript">
    function getQuery(){
        var url = location.search;//获取url中"?"符后的字串
        var theRequest ={};
        if(url.indexOf("?")!=-1){
            var str = url.substr(1);
            strs = str.split("&");
            for(var i =0; i < strs.length; i ++){
                theRequest[strs[i].split("=")[0]]= unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
    window.params = getQuery();
    $(function () {
        var vueBox = new Vue({
            el: '#app',
            data: {
                isDisabled:false,
                ruleForm: {
                    id:'',
                    title: '',
                    rules:''
                },
                rules: {
                    title:[
                        { required: true, message: '请输入角色名称', trigger: 'blur' },
                        { min: 2, max: 64, message: '长度在 2 到 64 个字符', trigger: 'blur' }
                    ]
                },
                id:window.getQuery().id,
                groupInfo:[],
                ruleList:[],
                groupRules:[],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                }
            },
            created: function () {
                this.query = window.getQuery();
                this.getGroupInfo(this.query.id);
            },
            methods: {
                submitForm: function(formName) {
                    var _self = this;
                    _self.isDisabled=true;

                    this.$refs[formName].validate(function (valid) {
                        _self.isDisabled=false;
                        if (valid) {
                            $.ajax({
                                type:'post',
                                url: "<?php echo url('/api/auth/save-group'); ?>",
                                data: _self.ruleForm,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.Code === '0') {
                                        _self.$message.success(result.Msg);
                                        window.location.href = '/admin/auth/group';
                                    }else{
                                        _self.$message.error(result.Msg);
                                        return false;
                                    }
                                }
                            });
                        } else {
                            console.log('error submit!!');
                            return false;
                        }
                    });
                },
                getGroupInfo: function (id) {
                    var selfObj = this
                    $.ajax({
                        type:'post',
                        url: "<?php echo url('/api/auth/group-info'); ?>",
                        data: {id:id},
                        dataType: 'json',
                        success: function(result) {
                            if (result.Code === '0') {
                                var resultData = result.Data;
                                if(resultData.id){
                                    selfObj.groupInfo = resultData;
                                    selfObj.ruleForm = resultData;
                                }
                            }
                        }
                    });
                },
            }
        })
    });
</script>



</body>
</html>