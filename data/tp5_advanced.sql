/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : tp5_advanced

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 23/11/2018 15:11:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_auth_department
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_department`;
CREATE TABLE `tb_auth_department`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '部门id',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '部门名称',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限系统-部门表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_auth_department
-- ----------------------------
INSERT INTO `tb_auth_department` VALUES (4, '超级管理员', 1542003877, 1542096290);

-- ----------------------------
-- Table structure for tb_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_group`;
CREATE TABLE `tb_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of tb_auth_group
-- ----------------------------
INSERT INTO `tb_auth_group` VALUES (1, '超级管理员', 1, '9,10,1,2,3,4,5,6,7,8,11,12,13,14,15,16,17,18,19,57,58,59,60,61,62,63,64,65,66,198,199,200,201,205,206,207', 1539594688, 1542953321);

-- ----------------------------
-- Table structure for tb_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_group_access`;
CREATE TABLE `tb_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of tb_auth_group_access
-- ----------------------------
INSERT INTO `tb_auth_group_access` VALUES (1, 1);
INSERT INTO `tb_auth_group_access` VALUES (3, 2);
INSERT INTO `tb_auth_group_access` VALUES (4, 3);
INSERT INTO `tb_auth_group_access` VALUES (5, 4);
INSERT INTO `tb_auth_group_access` VALUES (6, 5);
INSERT INTO `tb_auth_group_access` VALUES (7, 3);
INSERT INTO `tb_auth_group_access` VALUES (8, 2);
INSERT INTO `tb_auth_group_access` VALUES (9, 3);
INSERT INTO `tb_auth_group_access` VALUES (10, 4);
INSERT INTO `tb_auth_group_access` VALUES (11, 2);

-- ----------------------------
-- Table structure for tb_auth_position
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_position`;
CREATE TABLE `tb_auth_position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `code` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '职位代码',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '职位名称',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限系统-职位表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_auth_position
-- ----------------------------
INSERT INTO `tb_auth_position` VALUES (1, 'YH00001', '超级管理员', 1539308622, 1539765486);

-- ----------------------------
-- Table structure for tb_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_rule`;
CREATE TABLE `tb_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `rule` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `is_menu` tinyint(3) NOT NULL DEFAULT 0,
  `sort` int(11) NULL DEFAULT 0,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `highlight` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 208 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of tb_auth_rule
-- ----------------------------
INSERT INTO `tb_auth_rule` VALUES (1, 0, 'Auth', '', '权限管理', 'menu_auth', 1, 10, 0, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (2, 1, 'backend/Auth/departmentList', '/admin/auth/department', '公司架构', '', 1, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (3, 1, 'backend/Auth/userList', '/admin/auth/user', '账号管理', '', 1, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (4, 1, 'backend/Auth/groupList', '/admin/auth/group', '角色管理', '', 1, 0, 1, 1, '', '4');
INSERT INTO `tb_auth_rule` VALUES (5, 1, 'backend/Auth/positionList', '/admin/auth/position', '职位管理', '', 1, 0, 1, 1, '', '5');
INSERT INTO `tb_auth_rule` VALUES (6, 1, 'backend/Auth/ajaxSaveDepartment', '/api/auth/save-department', '公司架构编辑', '', 2, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (7, 1, 'backend/Auth/ajaxGetDepartmentList', '/api/auth/department-list', '公司架构列表', '', 2, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (8, 1, 'backend/Auth/ajaxDeleteDepartment', '/api/auth/delete-department', '公司架构删除', '', 2, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (9, 0, 'Home', '', '首页', 'menu_home', 1, 300, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (10, 9, 'backend/Home/index', '/admin/home', '首页', '', 1, 0, 1, 1, '', '10');
INSERT INTO `tb_auth_rule` VALUES (11, 1, 'backend/Auth/editRule', '/admin/auth/rule-edit', '功能编辑', '', 2, 0, 1, 1, '', '61');
INSERT INTO `tb_auth_rule` VALUES (12, 1, 'backend/Auth/ajaxUserList', '/api/auth/user-list', '账号列表', '', 2, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (13, 1, 'backend/Auth/ajaxUserInfo', '/api/auth/user-info', '账号详情', '', 2, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (14, 1, 'backend/Auth/ajaxSaveUser', '/api/auth/save-user', '账号保存', '', 2, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (15, 1, 'backend/Auth/ajaxDeleteUser', '/api/auth/delete-user', '账号删除', '', 2, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (16, 1, 'backend/Auth/editGroup', '/admin/auth/group-edit', '角色编辑', '', 2, 0, 1, 1, '', '4');
INSERT INTO `tb_auth_rule` VALUES (17, 1, 'backend/Auth/ajaxGetGroupList', '/api/auth/group-list', '角色列表', '', 2, 0, 1, 1, '', '4');
INSERT INTO `tb_auth_rule` VALUES (18, 1, 'backend/Auth/ajaxGetGroupInfo', '/api/auth/group-info', '角色详情', '', 2, 0, 1, 1, '', '4');
INSERT INTO `tb_auth_rule` VALUES (19, 1, 'backend/Auth/ajaxSaveGroup', '/api/auth/save-group', '角色删除', '', 2, 0, 1, 1, '', '4');
INSERT INTO `tb_auth_rule` VALUES (201, 1, 'backend/Auth/getDepartmentInfo', '/api/auth/department-detail', '获取公司架构详情', '', 2, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (57, 1, 'backend/Auth/editUser', '/admin/auth/user-edit', '编辑用户', '', 2, 0, 1, 1, '', '3');
INSERT INTO `tb_auth_rule` VALUES (58, 1, 'backend/Auth/ajaxGetPositionList', '/api/auth/position-list', '获取职位列表', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (59, 1, 'backend/Auth/ajaxDeletePosition', '/api/auth/delete-position', '删除职位信息', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (60, 1, 'backend/Auth/ajaxSavePosition', '/api/auth/save-position', '保存职位信息', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (61, 1, 'backend/Auth/ruleList', '/admin/auth/rule', '功能列表', '', 1, 0, 1, 1, '', '61');
INSERT INTO `tb_auth_rule` VALUES (62, 1, 'backend/Auth/ajaxGetRuleList', '/api/auth/rule-list', '获取功能列表', '', 2, 0, 1, 1, '', '61');
INSERT INTO `tb_auth_rule` VALUES (63, 1, 'backend/Auth/ajaxRuleInfo', '/api/auth/rule-info', '获取功能详情', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (64, 1, 'backend/Auth/ajaxSaveRule', '/api/auth/save-rule', '保存功能信息', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (65, 1, 'backend/Auth/ajaxDeleteRule', '/api/auth/delete-rule', '删除功能信息', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (66, 1, 'backend/Auth/ajaxGetGroupRuleIds', '/api/auth/group-rule-ids', '获取角色列表', '', 2, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (206, 205, 'backend/Auth/changePassword', '/admin/auth/change-pass', '修改密码', '', 1, 0, 1, 1, '', '206');
INSERT INTO `tb_auth_rule` VALUES (205, 0, 'sys', '', '系统管理', 'menu_setting', 1, 0, 1, 1, '', '0');
INSERT INTO `tb_auth_rule` VALUES (200, 1, 'backend/Auth/getPositionInfo', '/api/auth/position-detail', '获取职位详情', '', 2, 0, 1, 1, '', '5');
INSERT INTO `tb_auth_rule` VALUES (207, 205, 'backend/Auth/changePass', '/api/auth/change-pass', '修改密码接口', '', 2, 0, 1, 1, '', '206');
INSERT INTO `tb_auth_rule` VALUES (199, 1, 'backend/Auth/departmentDetail', 'auth/department-detail', '公司架构详情', '', 2, 0, 1, 1, '', '2');
INSERT INTO `tb_auth_rule` VALUES (198, 1, 'backend/Auth/positionDetail', '/admin/auth/position-detail', '职位详情', '', 2, 0, 1, 1, '', '5');

-- ----------------------------
-- Table structure for tb_auth_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_user`;
CREATE TABLE `tb_auth_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password_hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `salt` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `sex` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:男;2:女;',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '1:开启;2:禁用;',
  `department_id` int(11) NOT NULL DEFAULT 0 COMMENT '部门',
  `position_id` int(11) NOT NULL DEFAULT 0 COMMENT '职位',
  `creator_id` int(11) NOT NULL COMMENT '创建者',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `delete_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username_UNIQUE`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_auth_user
-- ----------------------------
INSERT INTO `tb_auth_user` VALUES (1, 'admin', 'fb9988c37e94a98e8c28a98b3eff1efc7222ed33', '6560', '伊禾农品', '13673715134', '1042080686@qq.com', 1, 1, 4, 1, 0, '测试', 0, 1539238863, 1542271956);

-- ----------------------------
-- Table structure for tb_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tb_login_log`;
CREATE TABLE `tb_login_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) UNSIGNED NOT NULL,
  `login_client` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `login_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 205 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '登录日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_login_log
-- ----------------------------
INSERT INTO `tb_login_log` VALUES (1, 2, 1, '127.0.0.1', 1539673052);
INSERT INTO `tb_login_log` VALUES (2, 1, 1, '127.0.0.1', 1539673318);
INSERT INTO `tb_login_log` VALUES (3, 1, 1, '127.0.0.1', 1539680467);
INSERT INTO `tb_login_log` VALUES (4, 1, 1, '127.0.0.1', 1539737925);
INSERT INTO `tb_login_log` VALUES (5, 1, 1, '127.0.0.1', 1539739514);
INSERT INTO `tb_login_log` VALUES (6, 3, 1, '127.0.0.1', 1539739975);
INSERT INTO `tb_login_log` VALUES (7, 1, 1, '127.0.0.1', 1539740009);
INSERT INTO `tb_login_log` VALUES (8, 1, 1, '127.0.0.1', 1539746008);
INSERT INTO `tb_login_log` VALUES (9, 1, 1, '127.0.0.1', 1539749174);
INSERT INTO `tb_login_log` VALUES (10, 1, 1, '127.0.0.1', 1539755560);
INSERT INTO `tb_login_log` VALUES (11, 1, 1, '127.0.0.1', 1539757764);
INSERT INTO `tb_login_log` VALUES (12, 1, 1, '127.0.0.1', 1539760044);
INSERT INTO `tb_login_log` VALUES (13, 1, 1, '127.0.0.1', 1539825239);
INSERT INTO `tb_login_log` VALUES (14, 1, 1, '127.0.0.1', 1539827277);
INSERT INTO `tb_login_log` VALUES (15, 1, 1, '127.0.0.1', 1539832604);
INSERT INTO `tb_login_log` VALUES (16, 1, 1, '127.0.0.1', 1539912121);
INSERT INTO `tb_login_log` VALUES (17, 1, 1, '127.0.0.1', 1539935924);
INSERT INTO `tb_login_log` VALUES (18, 1, 1, '127.0.0.1', 1540171381);
INSERT INTO `tb_login_log` VALUES (19, 1, 1, '127.0.0.1', 1540172102);
INSERT INTO `tb_login_log` VALUES (20, 1, 1, '127.0.0.1', 1540185997);
INSERT INTO `tb_login_log` VALUES (21, 1, 1, '127.0.0.1', 1540257524);
INSERT INTO `tb_login_log` VALUES (22, 1, 1, '127.0.0.1', 1540281273);
INSERT INTO `tb_login_log` VALUES (23, 1, 1, '127.0.0.1', 1540345061);
INSERT INTO `tb_login_log` VALUES (24, 1, 1, '127.0.0.1', 1540432478);
INSERT INTO `tb_login_log` VALUES (25, 1, 1, '127.0.0.1', 1540438798);
INSERT INTO `tb_login_log` VALUES (26, 1, 1, '127.0.0.1', 1540449304);
INSERT INTO `tb_login_log` VALUES (27, 1, 1, '127.0.0.1', 1540518098);
INSERT INTO `tb_login_log` VALUES (28, 1, 1, '127.0.0.1', 1540737921);
INSERT INTO `tb_login_log` VALUES (29, 1, 1, '127.0.0.1', 1540775911);
INSERT INTO `tb_login_log` VALUES (30, 1, 1, '127.0.0.1', 1540776134);
INSERT INTO `tb_login_log` VALUES (31, 1, 1, '127.0.0.1', 1540780969);
INSERT INTO `tb_login_log` VALUES (32, 3, 1, '127.0.0.1', 1540878106);
INSERT INTO `tb_login_log` VALUES (33, 3, 1, '127.0.0.1', 1540878277);
INSERT INTO `tb_login_log` VALUES (34, 1, 1, '127.0.0.1', 1540886587);
INSERT INTO `tb_login_log` VALUES (35, 3, 1, '127.0.0.1', 1540886613);
INSERT INTO `tb_login_log` VALUES (36, 1, 1, '127.0.0.1', 1540888783);
INSERT INTO `tb_login_log` VALUES (37, 1, 1, '127.0.0.1', 1540952894);
INSERT INTO `tb_login_log` VALUES (38, 1, 1, '127.0.0.1', 1541040747);
INSERT INTO `tb_login_log` VALUES (39, 1, 1, '127.0.0.1', 1541052753);
INSERT INTO `tb_login_log` VALUES (40, 1, 1, '127.0.0.1', 1541126197);
INSERT INTO `tb_login_log` VALUES (41, 1, 1, '127.0.0.1', 1541150338);
INSERT INTO `tb_login_log` VALUES (42, 1, 1, '127.0.0.1', 1541164963);
INSERT INTO `tb_login_log` VALUES (43, 3, 1, '127.0.0.1', 1541164983);
INSERT INTO `tb_login_log` VALUES (44, 3, 1, '127.0.0.1', 1541311711);
INSERT INTO `tb_login_log` VALUES (45, 1, 1, '127.0.0.1', 1541382583);
INSERT INTO `tb_login_log` VALUES (46, 5, 1, '127.0.0.1', 1541568628);
INSERT INTO `tb_login_log` VALUES (47, 5, 1, '127.0.0.1', 1541569523);
INSERT INTO `tb_login_log` VALUES (48, 1, 1, '127.0.0.1', 1541592464);
INSERT INTO `tb_login_log` VALUES (49, 1, 1, '127.0.0.1', 1541597709);
INSERT INTO `tb_login_log` VALUES (50, 1, 1, '127.0.0.1', 1541610966);
INSERT INTO `tb_login_log` VALUES (51, 5, 1, '127.0.0.1', 1541641652);
INSERT INTO `tb_login_log` VALUES (52, 3, 1, '127.0.0.1', 1541642872);
INSERT INTO `tb_login_log` VALUES (53, 5, 1, '127.0.0.1', 1541648313);
INSERT INTO `tb_login_log` VALUES (54, 5, 1, '127.0.0.1', 1541649893);
INSERT INTO `tb_login_log` VALUES (55, 5, 1, '127.0.0.1', 1541656485);
INSERT INTO `tb_login_log` VALUES (56, 5, 1, '127.0.0.1', 1541659368);
INSERT INTO `tb_login_log` VALUES (57, 5, 1, '127.0.0.1', 1541659376);
INSERT INTO `tb_login_log` VALUES (58, 1, 1, '127.0.0.1', 1541692386);
INSERT INTO `tb_login_log` VALUES (59, 3, 1, '127.0.0.1', 1541726220);
INSERT INTO `tb_login_log` VALUES (60, 1, 1, '127.0.0.1', 1541727065);
INSERT INTO `tb_login_log` VALUES (61, 5, 1, '127.0.0.1', 1541727158);
INSERT INTO `tb_login_log` VALUES (62, 5, 1, '127.0.0.1', 1541727305);
INSERT INTO `tb_login_log` VALUES (63, 5, 1, '127.0.0.1', 1541727533);
INSERT INTO `tb_login_log` VALUES (64, 1, 1, '127.0.0.1', 1541727703);
INSERT INTO `tb_login_log` VALUES (65, 3, 1, '127.0.0.1', 1541730467);
INSERT INTO `tb_login_log` VALUES (66, 3, 1, '127.0.0.1', 1541731165);
INSERT INTO `tb_login_log` VALUES (67, 4, 1, '127.0.0.1', 1541733326);
INSERT INTO `tb_login_log` VALUES (68, 1, 1, '127.0.0.1', 1541733490);
INSERT INTO `tb_login_log` VALUES (69, 1, 1, '127.0.0.1', 1541734066);
INSERT INTO `tb_login_log` VALUES (70, 6, 1, '127.0.0.1', 1541734242);
INSERT INTO `tb_login_log` VALUES (71, 3, 1, '127.0.0.1', 1541734474);
INSERT INTO `tb_login_log` VALUES (72, 1, 1, '127.0.0.1', 1541738478);
INSERT INTO `tb_login_log` VALUES (73, 7, 1, '127.0.0.1', 1541738590);
INSERT INTO `tb_login_log` VALUES (74, 1, 1, '127.0.0.1', 1541740072);
INSERT INTO `tb_login_log` VALUES (75, 3, 1, '127.0.0.1', 1541741636);
INSERT INTO `tb_login_log` VALUES (76, 3, 1, '127.0.0.1', 1541744754);
INSERT INTO `tb_login_log` VALUES (77, 1, 1, '58.38.220.180', 1541745189);
INSERT INTO `tb_login_log` VALUES (78, 1, 1, '58.38.220.180', 1541746010);
INSERT INTO `tb_login_log` VALUES (79, 1, 1, '58.38.220.180', 1541746493);
INSERT INTO `tb_login_log` VALUES (80, 3, 1, '127.0.0.1', 1541747995);
INSERT INTO `tb_login_log` VALUES (81, 1, 1, '58.38.220.180', 1541751500);
INSERT INTO `tb_login_log` VALUES (82, 5, 1, '127.0.0.1', 1541752262);
INSERT INTO `tb_login_log` VALUES (83, 1, 1, '58.38.220.180', 1541752268);
INSERT INTO `tb_login_log` VALUES (84, 1, 1, '127.0.0.1', 1541752307);
INSERT INTO `tb_login_log` VALUES (85, 5, 1, '127.0.0.1', 1541752688);
INSERT INTO `tb_login_log` VALUES (86, 4, 1, '127.0.0.1', 1541754084);
INSERT INTO `tb_login_log` VALUES (87, 3, 1, '127.0.0.1', 1541754285);
INSERT INTO `tb_login_log` VALUES (88, 1, 1, '58.38.220.180', 1541755211);
INSERT INTO `tb_login_log` VALUES (89, 1, 1, '58.38.220.180', 1541986176);
INSERT INTO `tb_login_log` VALUES (90, 1, 1, '127.0.0.1', 1541987161);
INSERT INTO `tb_login_log` VALUES (91, 3, 1, '127.0.0.1', 1541987966);
INSERT INTO `tb_login_log` VALUES (92, 3, 1, '127.0.0.1', 1542002521);
INSERT INTO `tb_login_log` VALUES (93, 1, 1, '58.38.220.180', 1542003155);
INSERT INTO `tb_login_log` VALUES (94, 1, 1, '127.0.0.1', 1542003475);
INSERT INTO `tb_login_log` VALUES (95, 8, 1, '58.38.220.180', 1542005882);
INSERT INTO `tb_login_log` VALUES (96, 1, 1, '58.38.220.180', 1542005944);
INSERT INTO `tb_login_log` VALUES (97, 9, 1, '58.38.220.180', 1542006087);
INSERT INTO `tb_login_log` VALUES (98, 8, 1, '58.38.220.180', 1542006151);
INSERT INTO `tb_login_log` VALUES (99, 1, 1, '58.38.220.180', 1542006167);
INSERT INTO `tb_login_log` VALUES (100, 8, 1, '58.38.220.180', 1542006195);
INSERT INTO `tb_login_log` VALUES (101, 1, 1, '58.38.220.180', 1542006285);
INSERT INTO `tb_login_log` VALUES (102, 10, 1, '58.38.220.180', 1542006648);
INSERT INTO `tb_login_log` VALUES (103, 9, 1, '58.38.220.180', 1542007980);
INSERT INTO `tb_login_log` VALUES (104, 8, 1, '58.38.220.180', 1542008216);
INSERT INTO `tb_login_log` VALUES (105, 10, 1, '58.38.220.180', 1542008230);
INSERT INTO `tb_login_log` VALUES (106, 9, 1, '58.38.220.180', 1542008268);
INSERT INTO `tb_login_log` VALUES (107, 8, 1, '58.38.220.180', 1542008382);
INSERT INTO `tb_login_log` VALUES (108, 10, 1, '58.38.220.180', 1542008395);
INSERT INTO `tb_login_log` VALUES (109, 9, 1, '58.38.220.180', 1542008478);
INSERT INTO `tb_login_log` VALUES (110, 1, 1, '58.38.220.180', 1542008544);
INSERT INTO `tb_login_log` VALUES (111, 6, 1, '58.38.220.180', 1542008560);
INSERT INTO `tb_login_log` VALUES (112, 1, 1, '58.38.220.180', 1542008611);
INSERT INTO `tb_login_log` VALUES (113, 6, 1, '58.38.220.180', 1542008710);
INSERT INTO `tb_login_log` VALUES (114, 1, 1, '58.38.220.180', 1542008755);
INSERT INTO `tb_login_log` VALUES (115, 9, 1, '58.38.220.180', 1542008864);
INSERT INTO `tb_login_log` VALUES (116, 6, 1, '58.38.220.180', 1542008887);
INSERT INTO `tb_login_log` VALUES (117, 9, 1, '58.38.220.180', 1542009304);
INSERT INTO `tb_login_log` VALUES (118, 10, 1, '58.38.220.180', 1542009375);
INSERT INTO `tb_login_log` VALUES (119, 9, 1, '58.38.220.180', 1542009397);
INSERT INTO `tb_login_log` VALUES (120, 1, 1, '58.38.220.180', 1542009484);
INSERT INTO `tb_login_log` VALUES (121, 10, 1, '58.38.220.180', 1542009496);
INSERT INTO `tb_login_log` VALUES (122, 6, 1, '58.38.220.180', 1542009525);
INSERT INTO `tb_login_log` VALUES (123, 1, 1, '58.38.220.180', 1542009570);
INSERT INTO `tb_login_log` VALUES (124, 9, 1, '58.38.220.180', 1542010040);
INSERT INTO `tb_login_log` VALUES (125, 8, 1, '58.38.220.180', 1542010190);
INSERT INTO `tb_login_log` VALUES (126, 1, 1, '127.0.0.1', 1542010592);
INSERT INTO `tb_login_log` VALUES (127, 1, 1, '58.38.220.180', 1542010913);
INSERT INTO `tb_login_log` VALUES (128, 1, 1, '58.38.220.180', 1542011341);
INSERT INTO `tb_login_log` VALUES (129, 9, 1, '127.0.0.1', 1542011580);
INSERT INTO `tb_login_log` VALUES (130, 1, 1, '127.0.0.1', 1542071575);
INSERT INTO `tb_login_log` VALUES (131, 1, 1, '127.0.0.1', 1542072487);
INSERT INTO `tb_login_log` VALUES (132, 1, 1, '127.0.0.1', 1542072976);
INSERT INTO `tb_login_log` VALUES (133, 1, 1, '127.0.0.1', 1542073158);
INSERT INTO `tb_login_log` VALUES (134, 1, 1, '127.0.0.1', 1542073282);
INSERT INTO `tb_login_log` VALUES (135, 1, 1, '58.38.220.180', 1542076548);
INSERT INTO `tb_login_log` VALUES (136, 1, 1, '58.38.220.180', 1542077855);
INSERT INTO `tb_login_log` VALUES (137, 1, 1, '58.38.220.180', 1542078173);
INSERT INTO `tb_login_log` VALUES (138, 1, 1, '127.0.0.1', 1542096949);
INSERT INTO `tb_login_log` VALUES (139, 1, 1, '58.38.220.180', 1542160619);
INSERT INTO `tb_login_log` VALUES (140, 1, 1, '127.0.0.1', 1542160745);
INSERT INTO `tb_login_log` VALUES (141, 1, 1, '58.38.220.180', 1542172639);
INSERT INTO `tb_login_log` VALUES (142, 1, 1, '58.38.220.180', 1542175600);
INSERT INTO `tb_login_log` VALUES (143, 9, 1, '58.38.220.180', 1542179710);
INSERT INTO `tb_login_log` VALUES (144, 1, 1, '58.38.220.180', 1542184855);
INSERT INTO `tb_login_log` VALUES (145, 1, 1, '58.38.220.180', 1542190347);
INSERT INTO `tb_login_log` VALUES (146, 1, 1, '127.0.0.1', 1542244269);
INSERT INTO `tb_login_log` VALUES (147, 1, 1, '58.38.220.180', 1542244928);
INSERT INTO `tb_login_log` VALUES (148, 1, 1, '127.0.0.1', 1542246423);
INSERT INTO `tb_login_log` VALUES (149, 9, 1, '127.0.0.1', 1542247324);
INSERT INTO `tb_login_log` VALUES (150, 5, 1, '127.0.0.1', 1542247373);
INSERT INTO `tb_login_log` VALUES (151, 1, 1, '58.38.220.180', 1542259570);
INSERT INTO `tb_login_log` VALUES (152, 1, 1, '127.0.0.1', 1542262930);
INSERT INTO `tb_login_log` VALUES (153, 1, 1, '58.38.220.180', 1542266236);
INSERT INTO `tb_login_log` VALUES (154, 1, 1, '127.0.0.1', 1542271927);
INSERT INTO `tb_login_log` VALUES (155, 1, 1, '127.0.0.1', 1542330511);
INSERT INTO `tb_login_log` VALUES (156, 1, 1, '58.38.220.180', 1542330680);
INSERT INTO `tb_login_log` VALUES (157, 1, 1, '58.38.220.180', 1542347441);
INSERT INTO `tb_login_log` VALUES (158, 1, 1, '58.38.220.180', 1542358094);
INSERT INTO `tb_login_log` VALUES (159, 1, 1, '58.38.81.179', 1542433522);
INSERT INTO `tb_login_log` VALUES (160, 1, 1, '127.0.0.1', 1542590667);
INSERT INTO `tb_login_log` VALUES (161, 1, 1, '127.0.0.1', 1542591157);
INSERT INTO `tb_login_log` VALUES (162, 1, 1, '58.38.220.180', 1542591534);
INSERT INTO `tb_login_log` VALUES (163, 1, 1, '58.38.220.180', 1542596991);
INSERT INTO `tb_login_log` VALUES (164, 9, 1, '58.38.220.180', 1542612330);
INSERT INTO `tb_login_log` VALUES (165, 8, 1, '58.38.220.180', 1542612397);
INSERT INTO `tb_login_log` VALUES (166, 9, 1, '58.38.220.180', 1542612413);
INSERT INTO `tb_login_log` VALUES (167, 1, 1, '58.38.220.180', 1542612536);
INSERT INTO `tb_login_log` VALUES (168, 9, 1, '58.38.220.180', 1542612566);
INSERT INTO `tb_login_log` VALUES (169, 1, 1, '58.38.220.180', 1542612917);
INSERT INTO `tb_login_log` VALUES (170, 9, 1, '58.38.220.180', 1542613599);
INSERT INTO `tb_login_log` VALUES (171, 1, 1, '58.38.220.180', 1542613637);
INSERT INTO `tb_login_log` VALUES (172, 9, 1, '58.38.220.180', 1542613651);
INSERT INTO `tb_login_log` VALUES (173, 1, 1, '58.38.220.180', 1542613686);
INSERT INTO `tb_login_log` VALUES (174, 9, 1, '58.38.220.180', 1542613704);
INSERT INTO `tb_login_log` VALUES (175, 1, 1, '58.38.220.180', 1542613744);
INSERT INTO `tb_login_log` VALUES (176, 10, 1, '58.38.220.180', 1542613792);
INSERT INTO `tb_login_log` VALUES (177, 1, 1, '58.38.220.180', 1542617430);
INSERT INTO `tb_login_log` VALUES (178, 1, 1, '58.38.220.180', 1542676176);
INSERT INTO `tb_login_log` VALUES (179, 1, 1, '58.38.220.180', 1542676969);
INSERT INTO `tb_login_log` VALUES (180, 1, 1, '127.0.0.1', 1542678064);
INSERT INTO `tb_login_log` VALUES (181, 1, 1, '180.171.34.88', 1542680292);
INSERT INTO `tb_login_log` VALUES (182, 1, 1, '58.38.220.180', 1542680918);
INSERT INTO `tb_login_log` VALUES (183, 1, 1, '127.0.0.1', 1542682403);
INSERT INTO `tb_login_log` VALUES (184, 1, 1, '58.38.220.180', 1542698787);
INSERT INTO `tb_login_log` VALUES (185, 1, 1, '127.0.0.1', 1542699488);
INSERT INTO `tb_login_log` VALUES (186, 1, 1, '58.38.220.180', 1542705057);
INSERT INTO `tb_login_log` VALUES (187, 1, 1, '58.38.220.180', 1542763731);
INSERT INTO `tb_login_log` VALUES (188, 11, 1, '58.38.220.180', 1542764173);
INSERT INTO `tb_login_log` VALUES (189, 1, 1, '58.38.220.180', 1542767680);
INSERT INTO `tb_login_log` VALUES (190, 11, 1, '58.38.220.180', 1542767702);
INSERT INTO `tb_login_log` VALUES (191, 1, 1, '127.0.0.1', 1542780047);
INSERT INTO `tb_login_log` VALUES (192, 1, 1, '127.0.0.1', 1542780055);
INSERT INTO `tb_login_log` VALUES (193, 1, 1, '127.0.0.1', 1542780072);
INSERT INTO `tb_login_log` VALUES (194, 1, 1, '58.38.220.180', 1542780172);
INSERT INTO `tb_login_log` VALUES (195, 1, 1, '58.38.220.180', 1542780902);
INSERT INTO `tb_login_log` VALUES (196, 1, 1, '127.0.0.1', 1542784366);
INSERT INTO `tb_login_log` VALUES (197, 1, 1, '58.38.220.180', 1542871088);
INSERT INTO `tb_login_log` VALUES (198, 1, 1, '58.38.220.180', 1542878684);
INSERT INTO `tb_login_log` VALUES (199, 1, 1, '58.38.220.180', 1542937452);
INSERT INTO `tb_login_log` VALUES (200, 1, 1, '127.0.0.1', 1542951310);
INSERT INTO `tb_login_log` VALUES (201, 1, 1, '127.0.0.1', 1542951833);
INSERT INTO `tb_login_log` VALUES (202, 1, 1, '127.0.0.1', 1542954402);
INSERT INTO `tb_login_log` VALUES (203, 1, 1, '127.0.0.1', 1542956148);
INSERT INTO `tb_login_log` VALUES (204, 1, 1, '127.0.0.1', 1542956923);

SET FOREIGN_KEY_CHECKS = 1;
