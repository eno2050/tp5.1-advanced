<?php /*a:2:{s:73:"E:\webwww\tp5.1-advanced\application\backend\view\auth\position_list.html";i:1542950402;s:59:"E:\webwww\tp5.1-advanced\application\backend\view\base.html";i:1542945489;}*/ ?>
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
        <span class="card-title">职位管理</span>
    </div>
    <div class="card-body">
        <el-form :inline="true" :model="positionInfo" size="mini" class="demo-form-inline">
            <el-form-item label="工号">
                <el-input v-model="positionInfo.code" placeholder="工号" size="mini"></el-input>
            </el-form-item>
            <el-form-item label="职位">
                <el-input v-model="positionInfo.name" placeholder="职位" size="mini"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" size="mini" @click="getPositionList">搜索</el-button>
            </el-form-item>
        </el-form>
    </div>
    <div class="card-body-blank">
        <template>
            <el-table
                    :data="positionList"
                    fit
                    border
                    highlight-current-row
                    header-row-class-name="table-header-th"
                    size="mini"
                    style="width: 100%">
                <el-table-column
                        prop="id"
                        label="编号"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="code"
                        label="工号"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="职位"
                        width="180">
                </el-table-column>
                <el-table-column
                        width="160"
                        prop="create_time"
                        label="添加时间">
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-button
                                type="primary"
                                size="mini"
                                @click="window.location='/admin/auth/position-detail?id='+scope.row.id">编辑</el-button>
                        <el-button
                                size="mini"
                                @click="deletePosition(scope.row.id)">删除</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </template>
    </div>

    <div class="card-footer">
        <el-button type="primary" size="mini" @click="window.location='/admin/auth/position-detail?id=0'">新增</el-button>
        <div class="right">
            <el-pagination
                    small
                    background
                    @current-change="getPositionList"
                    :current-page.sync="current"
                    :page-size="display"
                    layout="prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
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


<script>
    $(function () {
        var vueBox = new Vue({
            el: '#app',
            data: {
                total: 0,     // 记录总条数
                display: 20,   // 每页显示条数
                current: 1,     // 当前第n页 ， 也可以 watch current 的变化
                positionInfo: {
                    name: '',
                    code:''
                },
                positionList:[],
            },
            created: function () {
                this.getPositionList();
            },
            methods: {
                deletePosition:function(id){
                    var _self = this;
                    var postUrl = "<?php echo url('/api/auth/delete-position'); ?>";
                    _self.$confirm('此操作将永久删除该职位, 是否继续?', '提示', {
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
                                        message: '删除失败!'
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
                getPositionList: function () {
                    var selfObj = this;
                    var params = {
                        page:selfObj.current,
                        type:'page',
                        code: selfObj.positionInfo.code,
                        name: selfObj.positionInfo.name
                    };
                    $.ajax({
                        type:'post',
                        url: "<?php echo url('/api/auth/position-list'); ?>",
                        data: params,
                        dataType: 'json',
                        success: function(result) {
                            if (result.Code === '0') {
                                var resultData = result.Data;
                                var dataList = resultData.data;
                                selfObj.positionList = dataList;
                                selfObj.total = resultData.total;
                                selfObj.current = parseInt(resultData.current_page);
                                selfObj.display = resultData.per_page;
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