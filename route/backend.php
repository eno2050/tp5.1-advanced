<?php

use think\facade\Route;

Route::rule('/', 'backend/Index/index');
Route::rule('/login', 'backend/Login/login');

Route::group('admin', [
    //账号
    'auth/user' => 'backend/Auth/userList',
    'auth/change-pass' => 'backend/Auth/changePassword',
    'auth/user-edit' => 'backend/Auth/editUser',

    //角色
    'auth/group' => 'backend/Auth/groupList',
    'auth/group-edit' => 'backend/Auth/editGroup',
    'auth/group-allot-rule' => 'backend/Auth/groupAllotRule',

    //部门
    'auth/department' => 'backend/Auth/departmentList',
    'auth/department-detail' => 'backend/Auth/departmentDetail',

    //职位
    'auth/position' => 'backend/Auth/positionList',
    'auth/position-detail' => 'backend/Auth/positionDetail',
    
    //权限
    'auth/rule' => 'backend/Auth/ruleList',
    'auth/rule-edit' => 'backend/Auth/editRule',

    //首页
    'home' => 'backend/Index/index',
]);

Route::group('api', [
     //登陆
    'loginCheck' => 'backend/Login/loginCheck',
    'logout' => 'backend/Login/logout',

    //用户
    'auth/change-pass' => 'backend/Auth/changePass',//修改密码
    'auth/user-list' => 'backend/Auth/ajaxUserList',//用户列表
    'auth/user-info' => 'backend/Auth/ajaxUserInfo', //用户信息
    'auth/delete-user' => 'backend/Auth/ajaxDeleteUser',//删除用户
    'auth/save-user' => 'backend/Auth/ajaxSaveUser',//保存用户信息

    //部门
    'auth/department-detail' => 'backend/Auth/getDepartmentInfo', //获取部门详情
    'auth/department-list' => 'backend/Auth/ajaxGetDepartmentList', //获取部门列表
    'auth/delete-department' => 'backend/Auth/ajaxDeleteDepartment', //删除部门
    'auth/save-department' => 'backend/Auth/ajaxSaveDepartment',   //保存部门信息

    //职位
    'auth/position-detail' => 'backend/Auth/getPositionInfo', //获取职位详情
    'auth/position-list' => 'backend/Auth/ajaxGetPositionList', //职位列表
    'auth/delete-position' => 'backend/Auth/ajaxDeletePosition', //删除职位
    'auth/save-position' => 'backend/Auth/ajaxSavePosition', //保存职位
    
    //权限&菜单
    'auth/rule-list' => 'backend/Auth/ajaxGetRuleList',  //权限列表
    'auth/rule-info' => 'backend/Auth/ajaxRuleInfo', //权限信息
    'auth/save-rule' => 'backend/Auth/ajaxSaveRule', //保存求权限
    'auth/delete-rule' => 'backend/Auth/ajaxDeleteRule', //删除权限
    'auth/group-rule-ids' => 'backend/Auth/ajaxGetGroupRuleIds',  //角色权限

    //角色
    'auth/group-list' => 'backend/Auth/ajaxGetGroupList', //角色列表
    'auth/group-info' => 'backend/Auth/ajaxGetGroupInfo', //觉折信息
    'auth/save-group' => 'backend/Auth/ajaxSaveGroup', //保存角色信息
    'auth/delete-group' => 'backend/Auth/ajaxDeleteGroup', //保存角色信息
]);