<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/9
 * Time: 16:19
 * Email: 1042080686@qq.com
 */

namespace app\backend\controller;

use think\App;
use Helper\Data;
use app\common\service\AuthService;
use app\common\controller\BaseAdmin;
use think\facade\Session;
use think\facade\Url;

/**
 * Class Auth
 * @package app\backend\controller
 */
class Auth extends BaseAdmin
{
    protected $authService;
    public function __construct(AuthService $authService,App $app = null)
    {
        $this->authService = $authService;
        parent::__construct($app);
    }

    /**
     * 部门列表
     * @return \think\response\View
     */
    public function departmentList(){
        return $this->loadFrame('auth/department_list');
    }
    /**
     * 部门详情
     * @return \think\response\View
     */
    public function departmentDetail(){
        return $this->loadFrame('auth/department_detail');
    }

    /**
     * ajax 获取部门列表
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetDepartmentList(){
        $list = $this->authService->getAuthDepartmentList();

        return $this->jsonResponse('0','',$list);
    }

    /**
     * 获取部门信息
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function getDepartmentInfo(){
        $result = $this->authService->getAuthDepartmentInfo();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 编辑部门信息
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function ajaxSaveDepartment(){
        $result = $this->authService->editAuthDepartment();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);

    }

    /**
     * 删除部门
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function ajaxDeleteDepartment(){
        $result = $this->authService->deleteAuthDepartment();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);

    }

    /**
     * 职位列表
     * @return \think\response\View
     */
    public function positionList(){
        return $this->loadFrame('auth/position_list');
    }

    /**
     * 职位详情
     * @return \think\response\View
     */
    public function positionDetail(){
        return $this->loadFrame('auth/position_detail');
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPositionInfo(){
        $result = $this->authService->getAuthPositionInfo();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * ajax 获取职位列表
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetPositionList(){
        $list = $this->authService->getAuthPositionList();

        return $this->jsonResponse('0','',$list);

    }

    /**
     * 编辑职位
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function ajaxSavePosition(){
        $result = $this->authService->editAuthPosition();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);

    }

    /**
     * 删除职位
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function ajaxDeletePosition(){
        $result = $this->authService->deleteAuthPosition();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);

    }

    /**
     * 角色列表
     * @return \think\response\View
     */
    public function groupList(){
        return $this->loadFrame('auth/group_list');
    }

    /**
     * 角色编辑
     * @return \think\response\View
     */
    public function editGroup(){
        return $this->loadFrame('auth/group_edit');
    }
    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxSaveGroup(){
        $result = $this->authService->editAuthGroup();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 获取角色列表
     * @return \think\Response|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function ajaxGetGroupList(){
        $list = $this->authService->getAuthGroupList();

        return $this->jsonResponse('0','',$list);
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetGroupInfo(){
        $result = $this->authService->getAuthGroupInfo();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);

    }
    /**
     * 删除角色
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function ajaxDeleteGroup(){
        $result = $this->authService->deleteAuthGroup();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }
    /**
     * 分配权限
     */
    public function allotRule()
    {
        $result = $this->authService->allotAuthRule();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 账号管理
     * @return \think\response\View
     */
    public function userList(){
        return $this->loadFrame('auth/user_list');
    }

    /**
     * 账号密码修改
     * @return \think\response\View
     */
    public function changePassword(){
        return $this->loadFrame('auth/change_password');
    }

    /**
     * 账号密码修改 ajax
     * @return \think\response\View
     */
    public function changePass(){
        $result = $this->authService->changePassword();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * @return \think\response\View
     */
    public function editUser(){
        return $this->loadFrame('auth/user_edit');
    }

    /**
     * 账号列表
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function ajaxUserList(){
        $type = $this->request->param('type','page');

        $userList = $this->authService->getAuthUserList($type);

        return $this->jsonResponse('0','请求成功',$userList);
    }

    /**
     * 获取账号信息
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxUserInfo(){
        $result = $this->authService->getAuthUserInfo();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 添加或编辑账号
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function ajaxSaveUser(){
        $result = $this->authService->saveAuthUser();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 删除账号
     * @return \think\Response|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function ajaxDeleteUser(){
        $result = $this->authService->deleteAuthUser();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 权限列表
     * @return \think\response\View
     */
    public function ruleList(){
        return $this->loadFrame('auth/rule_list');
    }

    /**
     * @return \think\response\View
     */
    public function editRule(){
        return $this->loadFrame('auth/rule_edit');
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetRuleList(){
        $result = $this->authService->getAuthRuleList();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetGroupRuleIds(){
        $result = $this->authService->getAuthGroupRuleIds();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * @return \think\Response
     */
    public function ajaxSaveRule(){
        $result = $this->authService->saveAuthRule();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxRuleInfo(){
        $result = $this->authService->getAuthRuleInfo();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * 权限删除
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxDeleteRule(){
        $result = $this->authService->deleteAuthRule();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }
}