<?php

/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/11
 * Time: 11:07
 * Email: 1042080686@qq.com
 */

namespace app\common\util\table;


class CommonTable
{
  const TB_AUTH_USER = 'tb_auth_user'; //系统用户表
  const TB_AUTH_RULE = 'tb_auth_rule'; //功能表
  const TB_AUTH_GROUP = 'tb_auth_group'; //用户组表
  const TB_AUTH_GROUP_ACCESS = 'tb_auth_group_access'; //用户组关联表
  const TB_AUTH_DEPARTMENT = 'tb_auth_department'; //部门表
  const TB_AUTH_POSITION = 'tb_auth_position'; //职位表

  const TB_LOGIN_LOG = 'tb_login_log'; //登录日志表
}