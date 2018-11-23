<?php /*a:2:{s:69:"E:\webwww\tp5.1-advanced\application\backend\view\auth\rule_list.html";i:1542950452;s:59:"E:\webwww\tp5.1-advanced\application\backend\view\base.html";i:1542945489;}*/ ?>
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
                        
 

<div class="card-wrap">
    <div class="card-header">
        <span class="card-title">权限管理</span>
        <div class="right">
            <el-button type="primary" size="mini" @click="window.location='/admin/auth/rule-edit?id=0'">新增</el-button>
        </div>
    </div>
    <div class="card-body-blank">
        <template>
            <el-table
                    :data="ruleList"
                    fit
                    border
                    highlight-current-row
                    header-row-class-name="table-header-th"
                    size="mini"
                    style="width: 100%">
                <el-table-column
                        prop="id"
                        width="60"
                        label="编号">
                </el-table-column>
                <el-table-column
                        label="权限" width="200" align="left">
                    <template slot-scope="scope">
                        <span v-html="scope.row._name"></span>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="name"
                        width="350"
                        label="路由">
                </el-table-column>
                <el-table-column
                        prop="rule"
                        width="260"
                        label="规则">
                </el-table-column>
                <el-table-column
                        width="100"
                        label="类型">
                    <template slot-scope="scope">
                        <span v-if="scope.row.is_menu==1"><i class="el-icon-menu"></i>菜单</span>
                        <span v-else>节点</span>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="sort"
                        width="50"
                        label="排序">
                </el-table-column>
                <el-table-column label="操作" width="160" align="left">
                    <template slot-scope="scope">
                        <el-button
                                type="primary"
                                size="mini"
                                @click="window.location='/admin/auth/rule-edit?id='+scope.row.id">编辑</el-button>
                        <el-button
                                size="mini"
                                @click="deleteRule(scope.row.id)">删除</el-button>
                        <el-button
                                v-if="false"
                                v-show="scope.row.pid==0"
                                size="mini"
                                type="danger"
                                @click="window.location='/admin/auth/rule-edit?pid='+scope.row.id+'&id=0'">添加子权限</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </template>
    </div>
</div>


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


<script>
    $(function () {
        var vueBox = new Vue({
            el: '#app',
            data: {
                ruleList:[],
                ruleInfo:{}
            },
            created: function () {
                this.getRuleList()
            },
            methods: {
                deleteRule:function(id){
                    var _self = this
                    var postUrl = "<?php echo url('/api/auth/delete-rule'); ?>";
                    _self.$confirm('此操作将永久删除该权限, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        $.ajax({
                            type:'POST',
                            url: postUrl,
                            data: {id:id},
                            dataType: 'json',
                            success: function(result) {
                                if (result.Code === '0') {
                                    _self.$message({
                                        type: 'success',
                                        message: '删除成功!'
                                    });
                                    window.location.reload(true);
                                }else{
                                    _self.$message({
                                        type: 'error',
                                        message: result.Msg
                                    });
                                }
                            }
                        });
                    }).catch(() => {
                        _self.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                },
                getRuleList: function () {
                    var selfObj = this;
                    $.ajax({
                        type:'post',
                        url: "<?php echo url('/api/auth/rule-list'); ?>",
                        data: {type:'tree'},
                        dataType: 'json',
                        success: function(result) {
                            if (result.Code === '0') {
                                var resultData = result.Data;
                                selfObj.ruleList = resultData
                            }
                        }
                    });
                }
            }
        })
    })
</script>


</body>
</html>