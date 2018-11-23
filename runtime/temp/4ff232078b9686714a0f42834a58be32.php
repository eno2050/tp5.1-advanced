<?php /*a:2:{s:69:"E:\webwww\tp5.1-advanced\application\backend\view\auth\rule_edit.html";i:1542950425;s:59:"E:\webwww\tp5.1-advanced\application\backend\view\base.html";i:1542945489;}*/ ?>
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
        <span v-show="id!=0">编辑权限</span>
        <span v-show="pid">添加子权限</span>
        <span v-show="id==0 && !pid">添加权限</span>
    </div>

    <div class="text item text-center">
        <template>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" size="medium" class="demo-ruleForm">
                        <el-form-item label="权限名称" prop="title">
                            <el-input v-model="ruleForm.title" placeholder="权限名称"></el-input>
                        </el-form-item>
                        <el-form-item label="路由" prop="name">
                            <el-input v-model="ruleForm.name" placeholder="路由"></el-input>
                        </el-form-item>
                        <el-form-item label="规则" prop="rule">
                            <el-input v-model="ruleForm.rule" placeholder="规则"></el-input>
                        </el-form-item>
                        <el-form-item label="图标" prop="icon">
                            <el-input v-model="ruleForm.icon" placeholder="icon 图标"></el-input>
                        </el-form-item>
                        <el-form-item label="高亮ID" prop="highlight">
                            <el-input v-model="ruleForm.highlight" placeholder="高亮"></el-input>
                        </el-form-item>
                        <el-form-item label="排序" prop="sort">
                            <el-input v-model="ruleForm.sort" placeholder="越大越靠前"></el-input>
                        </el-form-item>
                        <el-form-item label="类型" prop="is_menu">
                            <el-select v-model="ruleForm.is_menu" placeholder="类型">
                                <el-option
                                        v-for="item in typeList"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="submitForm('ruleForm')" :disabled="isDisabled">提交</el-button>
                            <el-button @click="resetForm('ruleForm')">重置</el-button>
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
            data() {
                return {
                    typeList:[
                        {id:1,name:'菜单'},
                        {id:2,name:'节点'},
                    ],
                    isDisabled:false,
                    ruleForm: {
                        id:'',
                        title: '',
                        name:'',
                        rule:'',
                        icon:'',
                        is_menu:'',
                        sort:0,
                        highlight:0,
                        pid:0
                    },
                    rules: {
                        title:[
                            { required: true, message: '请输入权限名称', trigger: 'blur' },
                            { min: 2, max: 64, message: '长度在 3 到 64 个字符', trigger: 'blur' }
                        ],
                        is_menu:[
                            { required: true, message: '请选择类别', trigger: 'change' }
                        ]
                    },
                    id:window.getQuery().id,
                    pid:window.getQuery().pid,
                    query:{},
                    ruleInfo:[],
                    groupList:[],
                    departmentList:[],
                    positionList:[]
                }
            },
            created: function () {
                this.query = window.getQuery();
                this.getRuleInfo(this.query.id);
            },
            methods: {
                submitForm(formName) {
                    var _self = this;
                    _self.isDisabled=true;
                    this.$refs[formName].validate((valid) => {
                        _self.isDisabled=false;
                        if (valid) {
                            if(_self.pid){
                                _self.ruleForm.pid = _self.pid;
                            }
                            $.ajax({
                                type:'post',
                                url: "<?php echo url('/api/auth/save-rule'); ?>",
                                data: _self.ruleForm,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.Code === '0') {
                                        _self.$message.success(result.Msg);
                                        window.location.href = '/admin/auth/rule';
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
                resetForm(formName) {
                    var _self = this;
                    _self.isDisabled=false;
                    this.$refs[formName].resetFields();
                },
                getRuleInfo: function (id) {
                    var selfObj = this
                    $.ajax({
                        type:'post',
                        url: "<?php echo url('/api/auth/rule-info'); ?>",
                        data: {id:id},
                        dataType: 'json',
                        success: function(result) {
                            if (result.Code === '0') {
                                var resultData = result.Data;
                                if(resultData.id){
                                    selfObj.ruleInfo = resultData;
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