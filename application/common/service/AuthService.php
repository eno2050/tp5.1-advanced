<?php

/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/10
 * Time: 16:08
 * Email: 1042080686@qq.com
 */

namespace app\common\service;

use app\common\model\AuthLoginLogModel;
use app\common\validate\FilterValidate;
use think\Db;
use Helper\Data;
use think\facade\Log;
use think\Request;
use think\facade\Session;
use app\common\model\AuthRuleModel;
use app\common\model\AuthUserModel;
use app\common\util\table\CommonTable;
use app\common\model\AuthGroupModel;
use app\common\model\AuthPositionModel;
use app\common\model\AuthDepartmentModel;
use app\common\model\AuthGroupAccessModel;
use app\common\validate\LoginCheckValid;

class AuthService extends BaseService
{
    protected $authUser;
    protected $request;
    protected $authRule;
    protected $authGroup;
    protected $authLoginLog;
    protected $authPosition;
    protected $authDepartment;
    protected $authGroupAccess;

    public function __construct(AuthLoginLogModel $authLoginLog, AuthPositionModel $authPosition, AuthDepartmentModel $authDepartment, AuthUserModel $authUser, Request $request, AuthGroupModel $authGroup, AuthGroupAccessModel $authGroupAccess, AuthRuleModel $authRule)
    {
        $this->authUser = $authUser;
        $this->request = $request;
        $this->authRule = $authRule;
        $this->authGroup = $authGroup;
        $this->authLoginLog = $authLoginLog;
        $this->authPosition = $authPosition;
        $this->authDepartment = $authDepartment;
        $this->authGroupAccess = $authGroupAccess;
    }

    /**
     * @param $type
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\exception\DbException
     */
    public function getAuthUserList($type)
    {
        $page_size = $this->request->param('page_size', 20);
        $username = $this->request->param('username');
        $name = $this->request->param('name');
        $group_id = $this->request->param('group_id');

        $params = [];

        $username && $params[] = ['au.username', 'like', "%{$username}%"];
        $name && $params[] = ['au.name', 'like', "%{$name}%"];
        $group_id && $params[] = ['aga.group_id', '=', $group_id];

        if ($type == 'page') {
            return $this->authUser->getUserList($params, $page_size);
        } else {
            return $this->authUser->getAllUserList($params);
        }
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthUserInfo()
    {
        $id = $this->request->post('id', 0);
        $map = array(
            'id' => $id
        );
        $user = $this->authUser->getUserInfo($map);

        if ($user) {
            unset($user['create_time']);
            unset($user['update_time']);
            unset($user['password_hash']);
        } else {
            $user = [];
        }

        return $this->returnMsg('0', '请求成功', $user);
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function saveAuthUser()
    {
        $admin = Session::get('userInfo');
        if ($admin['group_id'] != 1) {
            return $this->returnMsg('1001', '你没有该权限，请联系管理员');
        }

        $id = $this->request->param('id', 0, 'intval');
        $username = $this->request->param('username', '');
        $password = $this->request->param('password_hash', '');
        $group_id = $this->request->param('group_id', 0);
        $name = $this->request->param('name', '');
        $phone_mobile = $this->request->param('mobile', '');
        $email = $this->request->param('email', '');
        $position_id = $this->request->param('position_id', 0);
        $department_id = $this->request->param('department_id', 0);
        $sex = $this->request->param('sex', 1);
        $remark = $this->request->param('remark', '');

        $data = [];
        if (!$id && !$password) {
            return $this->returnMsg('1006', '请填写登录密码');
        }
        if (!$department_id) {
            return $this->returnMsg('1007', '请选择用户部门');
        }
        if (!$position_id) {
            return $this->returnMsg('1008', '请选择用户职位');
        }
        if (!$group_id) {
            return $this->returnMsg('1009', '请选择用户角色');
        }

        $id && $data['id'] = $id;
        $username && $data['username'] = $username;
        $name && $data['name'] = $name;
        $group_id && $data['group_id'] = $group_id;
        $password && $data['password_hash'] = $password;
        $email && $data['email'] = $email;
        $position_id && $data['position_id'] = $position_id;
        $department_id && $data['department_id'] = $department_id;
        $phone_mobile && $data['mobile'] = $phone_mobile;
        $sex && $data['sex'] = $sex;
        $remark && $data['remark'] = $remark;
        !$id && $data['creator_id'] = $admin['id'];

        $result = $this->authUser->saveRuleUser($data);
        if ($result['success'] === false) {
            return $this->returnMsg($result['code']);
        }
        return $this->returnMsg('0', '操作成功');
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteAuthUser()
    {
        $id = $this->request->post('id', 0);
        if (!$id) {
            return $this->returnMsg('1001', '参数异常');
        }
        $map = array(
            'id' => $id
        );
        $result = Db::table(CommonTable::TB_AUTH_USER)->where($map)->delete();
        if ($result) {
            return $this->returnMsg('0', '删除成功');
        } else {
            return $this->returnMsg('1003', '删除失败');
        }
    }

    /**
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getAuthGroupList()
    {
        $page_size = $this->request->param('page_size', 20);
        $type = $this->request->param('type', 'all');
        $params = [];

        if (isset($type) && $type == 'all') {
            $list = $this->authGroup->getAllGroupList($params);
        } else {
            $list = $this->authGroup->getGroupList($params, $page_size);

            $list->each(function (&$item) {
                $data = [];
                if ($item['rules']) {
                    $ids = explode(',', $item['rules']);
                    $data['id'] = $ids;
                    $data['pid'] = 0;
                    $rules = $this->authRule->getAllAuthRule($data, 'title');
                    $item['rules_list'] = implode(',', array_column($rules, 'title'));
                } else {
                    $item['rules_list'] = '';
                }
            });

        }
        return $list;
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthGroupInfo()
    {
        $id = $this->request->param('id', 0);

        if (!$id) {
            return $this->ReturnMsg('1000', '参数丢失');
        }
        $info = $this->authGroup->getGroupInfo(['id' => $id]);

        return $this->returnMsg('0', '请求成功', $info);
    }

    /**
     * 编辑用户组
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editAuthGroup()
    {
        $id = $this->request->param('id');
        $title = $this->request->param('title');
        $check_ids = $this->request->param('check_ids');
        $remark = $this->request->param('remark');

        $params = [];
        $params['title'] = $title;
        $remark && $params['remark'] = $remark;
        $check_ids && $params['rules'] = implode(',', $check_ids);
        if (!$id) {
            $count = $this->authGroup->getGroupCount(['title' => $params['title']]);
            if ($count > 0) {
                return $this->ReturnMsg('1001', '该用户组已添加，请修改后重试');
            }

            $result = $this->authGroup->saveGroup($params);

            if ($result) {
                return $this->ReturnMsg('0', '添加成功');
            } else {
                return $this->ReturnMsg('1000', '添加失败');
            }
        } else {
            $info1 = $this->authGroup->getGroupInfo(['id' => $id]);
            $info2 = $this->authGroup->getGroupInfo(['title' => $params['title']]);
            if ($info2 && ($info2['id'] != $info1['id'])) {
                return $this->returnMsg('1001', '该用户组已添加，请修改后重试');
            }

            $result = $this->authGroup->saveGroup($params, $id);

            if ($result) {
                return $this->returnMsg('0', '修改成功');
            } else {
                return $this->returnMsg('1001', '修改失败');
            }
        }
    }

    /**
     * 删除用户组
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteAuthGroup()
    {
        $id = $this->request->param('id');
        if (in_array($id, [1])) {
            return $this->returnMsg('1003', '该角色不能被删除');
        }
        $map = array(
            'id' => $id
        );
        $result = Db::table(CommonTable::TB_AUTH_GROUP)->where($map)->delete();
        if ($result) {
            return $this->returnMsg('0', '删除成功');
        } else {
            return $this->returnMsg('1003', '删除失败');
        }
    }

    /**
     * 分配权限
     * @return array
     */
    public function allotAuthRule()
    {
        $data = input('post.');
        $datas['rules'] = implode(',', $data['rule_ids']);
        $result = $this->authGroup->updateGroup($datas, $data['id']);
        if ($result) {
            return $this->returnMsg('0', '操作成功');
        } else {
            return $this->returnMsg('1005', '操作失败');
        }
    }

    /**
     * 部门列表
     * @return array|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthDepartmentList()
    {
        $page_size = $this->request->param('page_size', 20);
        $type = $this->request->param('type', 'all');
        $name = $this->request->param('name', '', 'trim');
        $params = [];

        $name && $params[] = ['name', 'like', "%{$name}%"];

        if (isset($type) && $type == 'all') {
            $list = $this->authDepartment->getAllDepartmentList($params);
        } else {
            $list = $this->authDepartment->getDepartmentList($params, $page_size);
        }
        return $list;
    }

    /**
     * 获取职位信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthDepartmentInfo()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg('1003', '参数异常');
        }
        $map = array(
            'id' => $id
        );
        $result = $this->authDepartment->getDepartmentInfo($map);

        return $this->returnMsg('0', '请求成功', $result);
    }

    /**
     * 编辑部门
     * @return array
     * @throws \think\exception\DbException
     */
    public function editAuthDepartment()
    {
        $data = $this->request->post();
        $id = intval($data['id']);
        if (!$id) {
            unset($data['id']);
            $count = $this->authDepartment->getDepartmentCount(['name' => $data['name']]);
            if ($count > 0) {
                return $this->ReturnMsg('1001', '该部门已添加，请修改后重试');
            }
            $result = $this->authDepartment->saveDepartment($data);
            if ($result) {
                return $this->ReturnMsg('0', '添加成功');
            } else {
                return $this->ReturnMsg('1000', '添加失败');
            }
        } else {
            $info1 = $this->authDepartment->getDepartmentInfo(['id' => $id]);
            $info2 = $this->authDepartment->getDepartmentInfo(['name' => $data['name']]);
            if ($info2 && ($info2['id'] != $info1['id'])) {
                return $this->returnMsg('1001', '该部门名称已存在，请修改后重试');
            }

            $result = $this->authDepartment->saveDepartment(['name'=>$data['name'],'remark' => $data['remark']], $id);

            if ($result) {
                return $this->returnMsg('0', '修改成功');
            } else {
                return $this->returnMsg('1001', '修改失败');
            }
        }
    }

    /**
     * 删除部门
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteAuthDepartment()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg('1003', '参数异常');
        }
        $map = array(
            'id' => $id
        );
        $result = Db::table(CommonTable::TB_AUTH_DEPARTMENT)->where($map)->delete();
        if ($result) {
            return $this->returnMsg('0', '删除成功');
        } else {
            return $this->returnMsg('1003', '删除失败');
        }
    }
    /**
     * 获取职位列表
     * @return array|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthPositionList()
    {
        $page_size = $this->request->param('page_size', 20);
        $type = $this->request->param('type', 'all');
        $name = $this->request->param('name', '', 'trim');
        $code = $this->request->param('code', '', 'trim');
        $params = [];

        $name && $params[] = ['name', 'like', "%{$name}%"];
        $code && $params[] = ['code', 'like', "%{$code}%"];

        if (isset($type) && $type == 'all') {
            $list = $this->authPosition->getAllPositionList($params);
        } else {
            $list = $this->authPosition->getPositionList($params, $page_size);
        }
        return $list;
    }

    /**
     * 获取职位信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthPositionInfo()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg('1003', '参数异常');
        }
        $map = array(
            'id' => $id
        );
        $result = $this->authPosition->getPositionInfo($map);

        return $this->returnMsg('0', '请求成功', $result);
    }

    /**
     * 编辑职位
     * @return array
     * @throws \think\exception\DbException
     */
    public function editAuthPosition()
    {
        $data = $this->request->post();
        $id = intval($data['id']);
        if (!$id) {
            unset($data['id']);
            $count = $this->authPosition->getPositionCount(['name' => $data['name']]);
            if ($count > 0) {
                return $this->ReturnMsg('1001', '该部门已添加，请修改后重试');
            }
            $result = $this->authPosition->savePosition($data);
            if ($result) {
                return $this->ReturnMsg('0', '添加成功');
            } else {
                return $this->ReturnMsg('1000', '添加失败');
            }
        } else {
            $info1 = $this->authPosition->getPositionInfo(['id' => $id]);
            $info2 = $this->authPosition->getPositionInfo(['name' => $data['name']]);
            if ($info2 && ($info2['id'] != $info1['id'])) {
                return $this->returnMsg('1001', '该部门名称已存在，请修改后重试');
            }

            $result = $this->authPosition->savePosition(['name' => $data['name'],'remark' => $data['remark']], $id);

            if ($result) {
                return $this->returnMsg('0', '修改成功');
            } else {
                return $this->returnMsg('1001', '修改失败');
            }
        }
    }

    /**
     * 删除职位
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteAuthPosition()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg('1003', '参数异常');
        }
        $map = array(
            'id' => $id
        );
        $result = Db::table(CommonTable::TB_AUTH_POSITION)->where($map)->delete();
        if ($result) {
            return $this->returnMsg('0', '删除成功');
        } else {
            return $this->returnMsg('1003', '删除失败');
        }
    }

    /**
     * 获取权限列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthRuleList()
    {
        $type = $this->request->param('type', 'tree');
        //所有权限
        $all = $this->authRule->getAllAuthRule([]);
        if ($type == 'tree') {
            $allRules = Data::tree($all, 'title', 'id', 'pid');
        } else {
            $allRules = [];
            if (is_array($all) && count($all) > 0) {
                foreach ($all as $key => $row) {
                    if ($row['pid'] == '0') {
                        $allRules[$row['id']] = [
                            'id' => $row['id'],
                            'label' => $row['title'],
                            'sort' => $row['sort'],
                            'children' => []
                        ];
                    } else {
                        $allRules[$row['pid']]['children'][] = [
                            'id' => $row['id'],
                            'sort' => $row['sort'],
                            'label' => $row['title']
                        ];
                    }
                }
            }
        }

        return $this->returnMsg('0', '请求成功', array_values($allRules));
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthRuleInfo()
    {
        $id = $this->request->post('id', 0);
        $map = array(
            'id' => $id
        );
        $rule = $this->authRule->getRuleInfo($map);

        return $this->returnMsg('0', '请求成功', $rule);
    }

    /**
     * 根据用户组查询权限id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthGroupRuleIds()
    {
        $groupRuleIds = [];
        $id = $this->request->param('id', 0);
        //角色权限
        $groupInfo = $this->authGroup->getGroupInfo(['id' => $id]);
        if ($groupInfo) {
            $groupRuleIds = explode(',', $groupInfo['rules']);
        }

        return $this->returnMsg('0', '请求成功', $groupRuleIds);
    }

    /**
     * @return array
     */
    public function saveAuthRule()
    {
        $data = $this->request->post();
        $id = isset($data['id']) ? intval($data['id']) : 0;

        if (!$id) {
            $result = $this->authRule->saveRule($data);
        } else {
            $result = $this->authRule->saveRule($data, $id);
        }
        if ($result) {
            return $this->returnMsg('0', '操作成功');
        } else {
            return $this->returnMsg('1003', '操作失败');
        }
    }

    /**
     * 权限删除
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function deleteAuthRule()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg('1004', '网络请求异常');
        }
        $map = array(
            'id' => $id
        );
        $model = $this->authRule->getRuleInfo($map);
        if (!$model) {
            return $this->returnMsg('1005', '未查询到该权限信息');
        }
        if ($model->getAttr('pid') == 0) {
            return $this->returnMsg('1006', '请先删除子权限');
        }

        $result = $model->delete();
        if ($result) {
            return $this->returnMsg('0', '删除成功');
        } else {
            return $this->returnMsg('1003', '删除失败');
        }
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginCheck()
    {
        $data = [
            'username' => $this->request->post('login_user'),
            'password' => $this->request->post('login_pwd')
        ];
        $validate = new LoginCheckValid();

        if ($validate->batch()->check($data) !== false) {
            $userInfo = $this->authUser->getByUserName($data['username']);
            if ($userInfo !== null) {
                if ($userInfo['status'] && ($userInfo['status'] == 1)) {
                    $pass = $this->authUser->encyptLoginPassword($data['password'], $userInfo['salt']);
                    if ($pass != $userInfo['password_hash']) {
                        return $this->returnMsg('500', '账户密码错误');
                    }
                    $user = $this->authUser->getUserData(['au.id' => $userInfo['id']]);

                    $user['rules'] = $user['rules'] ? explode(',', $user['rules']) : [];

                    Session::set('userInfo', $user);

                    $this->authLoginLog->addLog([
                        'admin_id' => $user['id'],
                        'login_ip' => $this->request->ip(),
                        'login_client' => 1
                    ]);

                    return $this->returnMsg('0', '登陆成功');
                } else {
                    return $this->returnMsg('403', '该账户已被禁用，请联系管理员');
                }
            } else {
                return $this->returnMsg('1001', '该账户不存在');
            }
        } else {
            $msg = implode(',', $validate->getError());

            return $this->returnMsg('1000', $msg);
        }
    }

    /**
     * 仓库管理模块，所有列表的筛选条件构造
     * @param $filter
     * @return array|\think\Response
     */
    public function getFilterConditions($filter)
    {
        $filter = array_filter($filter);
        $conditions = [];
        if ($filter) {
            $filterValidate = new FilterValidate();
            if (!$filterValidate->check($filter)) {
                return $this->returnMsg('2501', $filterValidate->getError());
            }

            if (isset($filter['create_time_from']) && isset($filter['creator_time_to'])) {
                if (strtotime($filter['create_time_from']) >= strtotime($filter['create_time_to'])) {
                    return $this->returnMsg('2502');
                }
            }

            $conditions = $this->formatConditions($filter);
        }

        // 没有选择负责人，默认调用自己和下属的单子
        if (!isset($filter['creator_id'])) {
            $userInfo = Session::get('userInfo');
            $authUserConditions = $this->getAuthUserConditions($userInfo['id'], $userInfo['group_id']);
            if (!empty($authUserConditions)) {
                $conditions[] = $authUserConditions;
            }
        }

        return $this->returnMsg('0', null, $conditions);
    }

    /**
     * 构造查询条件
     * @param $filter
     * @return array
     */
    private function formatConditions($filter)
    {
        if (empty($filter)) {
            return [];
        }

        $conditions = [];
        foreach ($filter as $k => $v) {
            if (mb_substr($k, -9) == 'time_from') {
                $conditions[] = [mb_substr($k, 0, -5), '>=', strtotime($v)];
            } elseif (mb_substr($k, -7) == 'time_to') {
                $conditions[] = [mb_substr($k, 0, -3), '<=', strtotime($v)];
            } else {
                $conditions[] = [$k, '=', $v];
            }
        }

        return $conditions;
    }


    /**
     * 获取 自己 以及 下属 的 user_id 条件查询语句
     * @param $userId
     * @param $userGroupId
     * @param string $idName
     * @return array
     */
    public function getAuthUserConditions($userId, $userGroupId, $idName = 'creator_id')
    {
        $userIds = array();
        if ($userGroupId == 2) {
            $userIds = $this->authUser->getUserIds([
                'aga.group_id' => 3
            ]);
        } elseif ($userGroupId == 3) {
            $userIds = array();
        } else {
            // 超级管理员、内控调用所有的单子
            return null;
        }

        if (!$userIds) {
            return [$idName, '=', $userId];
        } else {
            array_push($userIds, $userId);
            return [$idName, 'in', $userIds];
        }
    }

    /**
     * 获取自己、下属的信息
     * @param $userId
     * @param $userGroupId
     */
    public function getAuthUsers($userId, $userGroupId)
    {
        $userConditions = $this->getAuthUserConditions($userId, $userGroupId, 'id');

        $result = $this->authUser->field('id, username, department_id, position_id');

        if (!empty($userConditions)) {
            $result = $result->where([$userConditions]);
        }

        return $result->order('position_id ASC, id ASC')->select();
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function changePassword()
    {
        $id = $this->request->param('id', 0, 'intval');
        $password = $this->request->param('password', '');
        $password1 = $this->request->param('password1', '');
        $password2 = $this->request->param('password2', '');

        $data = [];
        if (!$id) {
            return $this->returnMsg('500', '参数异常');
        }
        if (!$password || !$password1 || !$password2) {
            return $this->returnMsg('1006', '请按要求填写');
        }
        $user = $this->authUser->getUserInfo(['id' => $id]);
        if (!$user) {
            return $this->returnMsg('404', '未查询到该用户信息');
        }
        $new_hash = $this->authUser->encyptLoginPassword($password, $user['salt']);
        if ($new_hash !== $user['password_hash']) {
            return $this->returnMsg('500', '原始密码不正确');
        }
        if ($password1 != $password2) {
            return $this->returnMsg('500', '两次密码输入不一致');
        }
        $data['id'] = $id;
        $password1 && $data['password_hash'] = $password1;

        $result = $this->authUser->changePassword($data);
        if ($result['success'] === false) {
            return $this->returnMsg($result['code']);
        }
        return $this->returnMsg('0', '操作成功');
    }
}