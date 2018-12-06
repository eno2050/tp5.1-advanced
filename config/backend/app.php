<?php
//配置文件
return [
    //是否进行权限验证
    'auth_check' => false,
    // 显示错误信息
    'show_error_msg' => true,
    // 异常页面的模板文件
    'exception_tmpl' => Env::get('app_path') . 'common/view/tpl/think_exception.tpl',
];