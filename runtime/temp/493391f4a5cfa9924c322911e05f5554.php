<?php /*a:2:{s:66:"E:\webwww\tp5.1-advanced\application\backend\view\index\index.html";i:1543471215;s:59:"E:\webwww\tp5.1-advanced\application\backend\view\base.html";i:1542945489;}*/ ?>
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
                        
 

<div class="flex">
    <div class="flex-auto">
        <div class="card-wrap mb2">
            <div class="card-header">
                <span class="card-title">快捷入口</span>
            </div>
            <div class="card-body">
                <span>不知道放啥</span>
            </div>
        </div>

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


<script type="text/javascript">
    var app = new Vue({
        el: '#app',
        data: {

        },
        methods: {
            XX: function () {

            }
        }
    });
</script>



</body>
</html>