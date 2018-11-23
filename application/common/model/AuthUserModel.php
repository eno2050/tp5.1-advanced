<?php

namespace app\common\model;

use app\common\util\table\CommonTable;
use think\Config;
use think\Db;
use think\exception\PDOException;

class AuthUserModel extends Base
{
    protected $table = CommonTable::TB_AUTH_USER;

    protected $autoWriteTimestamp = true;

    /**
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserDetail($params = [])
    {
        return self::field('*')->where($params)->find();
    }

    /**
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getById($id)
    {
        return self::field('*')->where(['id' => $id])->find();
    }

    /**
     * @param $params
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserData($params)
    {
        $userData = $this->alias('au')
            ->field('au.*, ag.title group_name, aga.group_id, ag.rules, ad.name department_name, ap.name position_name')
            ->join(CommonTable::TB_AUTH_DEPARTMENT . ' ad', 'ad.id=au.department_id', 'left')
            ->join(CommonTable::TB_AUTH_POSITION . ' ap', 'ap.id=au.position_id', 'left')
            ->join(CommonTable::TB_AUTH_GROUP_ACCESS . ' aga', 'aga.uid=au.id', 'left')
            ->join(CommonTable::TB_AUTH_GROUP . ' ag', 'ag.id=aga.group_id', 'left')
            ->where($params)
            ->order('id', 'DESC')
            ->find();

        return $userData ? $userData : [];
    }

    /**
     * @param $username
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getByUserName($username)
    {
        return self::field('*')->where(['username' => $username])->find();
    }

    /**
     * 登录密码加密
     * @param $loginPassword
     * @param $salt
     * @return string
     */
    public static function encyptLoginPassword($loginPassword, $salt)
    {
        return sha1(md5($loginPassword . $salt));
    }

    /**
     * 更新用户信息
     * @param $save
     * @return AuthUserModel
     */
    public static function saveUser($save)
    {
        return self::update($save);
    }

    /**
     * @param array $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserGroupInfo($params = [])
    {
        $info = Db::table(CommonTable::TB_AUTH_GROUP)->where($params)->find();

        return $info ? $info : [];
    }

    /**
     * 账号
     * @param array $params
     * @param int $page_size
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\exception\DbException
     */
    public function getUserList($params = [], $page_size = 20)
    {
        $userList = $this->alias('au')
            ->field('au.*, ag.title group_name, aga.group_id')
            ->join(CommonTable::TB_AUTH_GROUP_ACCESS . ' aga', 'aga.uid=au.id', 'left')
            ->join(CommonTable::TB_AUTH_GROUP . ' ag', 'ag.id=aga.group_id', 'left')
            ->where($params)
            ->order('id', 'DESC')
            ->paginate($page_size)
            ->each(function (&$item) {

                $userLog = Db::table(CommonTable::TB_LOGIN_LOG)
                    ->where(['admin_id' => $item['id']])
                    ->order('id')
                    ->find();
                $userLogCount = Db::table(CommonTable::TB_LOGIN_LOG)
                    ->where(['admin_id' => $item['id']])
                    ->order('id')
                    ->count();
                $departmentInfo = Db::table(CommonTable::TB_AUTH_DEPARTMENT)
                    ->where(['id' => $item['department_id']])
                    ->find();
                $item['department_name'] = $departmentInfo ? $departmentInfo['name'] : '';

                $positionInfo = Db::table(CommonTable::TB_AUTH_POSITION)
                    ->where(['id' => $item['position_id']])
                    ->find();
                $item['position_name'] = $positionInfo ? $positionInfo['name'] : '';

                $item['login_time'] = '';
                $item['login_count'] = intval($userLogCount);

                if ($userLog) {
                    $item['login_time'] = date('Y-m-d H:i', $userLog['create_time']);
                }
            });
        return $userList;
    }

    /**
     * @param array $params
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllUserList($params = [])
    {
        $userList = $this->alias('au')
            ->field('au.*, ag.title group_name, aga.group_id')
            ->join(CommonTable::TB_AUTH_GROUP_ACCESS . ' aga', 'aga.uid=au.id', 'left')
            ->join(CommonTable::TB_AUTH_GROUP . ' ag', 'ag.id=aga.group_id', 'left')
            ->where($params)
            ->order('id', 'DESC')
            ->select()
            ->each(function (&$item) {
                $userLog = Db::table(CommonTable::TB_LOGIN_LOG)
                    ->where(['admin_id' => $item['id']])
                    ->order('id')
                    ->find();

                $userLogCount = Db::table(CommonTable::TB_LOGIN_LOG)
                    ->where(['admin_id' => $item['id']])
                    ->order('id')
                    ->count();

                $departmentInfo = Db::table(CommonTable::TB_AUTH_DEPARTMENT)
                    ->where(['id' => $item['department_id']])
                    ->find();

                $item['department_name'] = $departmentInfo ? $departmentInfo['name'] : '';

                $positionInfo = Db::table(CommonTable::TB_AUTH_POSITION)
                    ->where(['id' => $item['position_id']])
                    ->find();

                $item['position_name'] = $positionInfo ? $positionInfo['name'] : '';

                $item['login_time'] = '';
                $item['login_count'] = intval($userLogCount);

                if ($userLog) {
                    $item['login_time'] = date('Y-m-d H:i', $userLog['create_time']);
                }
            });

        return $userList;
    }

    /**
     * @param array $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInfo($params = [])
    {
        $authGroupAccessModel = new AuthGroupAccessModel();
        $user = $this->where($params)->find();

        if ($user) {
            $userGroup = $authGroupAccessModel->getUserGroupAccessInfo(['aga.uid' => $user['id']]);
            $user['group_id'] = $userGroup ? $userGroup['id'] : '';
            $user['group_title'] = $userGroup ? $userGroup['title'] : '';

            $departmentInfo = Db::table(CommonTable::TB_AUTH_DEPARTMENT)
                ->where(['id' => $user['department_id']])
                ->find();
            $user['department_name'] = $departmentInfo ? $departmentInfo['name'] : '';

            $positionInfo = Db::table(CommonTable::TB_AUTH_POSITION)
                ->where(['id' => $user['position_id']])
                ->find();
            $user['position_name'] = $positionInfo ? $positionInfo['name'] : '';

        }

        return $user;
    }
    /**
     * @param array $data
     * @return array
     * @throws PDOException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function saveRuleUser($data = [])
    {
        $id = isset($data['id']) ? intval($data['id']) : '';
        $result = [
            'success' => false,
            'code' => '3200',
            'data' => [],
        ];
        try {
            self::startTrans();
            if (!$id) {
                $group_id = isset($data['group_id']) ? intval($data['group_id']) : '';
                if ($group_id) {
                    unset($data['group_id']);
                }
                $userInfo = self::getByUsername($data['username']);
                if (!empty($userInfo)) {
                    throw new \PDOException(Config::get('code.3202'), 3202);
                }

                $salt = generate_salt(4);
                $data['password_hash'] = self::encyptLoginPassword($data['password_hash'], $salt);
                $data['salt'] = $salt;

                $user = self::create($data);
                $id = $user->id;

                Db::table(CommonTable::TB_AUTH_GROUP_ACCESS)->where(['uid' => $id])->delete();
                if ($group_id) {
                    Db::table(CommonTable::TB_AUTH_GROUP_ACCESS)->insert(['uid' => $id, 'group_id' => $group_id]);
                }
            } else {
                $group_id = isset($data['group_id']) ? intval($data['group_id']) : '';
                if ($group_id) {
                    unset($data['group_id']);
                }
                $user = self::getByID($id);
                $userInfo = self::getByUsername($data['username']);
                if (!empty($userInfo) && ($userInfo->id != $id)) {
                    throw new \PDOException(Config::get('code.3202'), 3202);
                }

                if (isset($data['password_hash']) && !empty($data['password_hash'])) {
                    $data['password_hash'] = self::encyptLoginPassword($data['password_hash'], $user->salt);
                }

                $user->allowField(true)->save($data);

                Db::table(CommonTable::TB_AUTH_GROUP_ACCESS)->where(['uid' => $id])->delete();
                if ($group_id) {
                    Db::table(CommonTable::TB_AUTH_GROUP_ACCESS)->insert(['uid' => $id, 'group_id' => $group_id]);
                }
            }

            self::commit();

            $result['success'] = true;
            $result['code'] = '0';
            $result['data'] = [
                'userID' => $id
            ];

            return $result;
        } catch (\PDOException $e) {
            self::rollback();

            $result['code'] = $e->getCode();
            return $result;
        }
    }

    /**
     * @param array $data
     * @return array
     * @throws PDOException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changePassword($data = [])
    {
        $id = isset($data['id']) ? intval($data['id']) : '';
        $result = [
            'success' => false,
            'code' => '3200',
            'data' => [],
        ];
        try {
            self::startTrans();

            $user = self::getByID($id);

            if (isset($data['password_hash']) && !empty($data['password_hash'])) {
                $data['password_hash'] = self::encyptLoginPassword($data['password_hash'], $user->salt);
            }

            $user->allowField(true)->save($data);

            self::commit();

            $result['success'] = true;
            $result['code'] = '0';
            $result['data'] = [
                'userID' => $id
            ];

            return $result;
        } catch (\PDOException $e) {
            self::rollback();

            $result['code'] = $e->getCode();
            return $result;
        }
    }

    /**
     * @param array $params
     * @return array
     */
    public function getUserIds($params = [])
    {
        return $this->alias('au')
            ->join(CommonTable::TB_AUTH_GROUP_ACCESS . " aga", 'aga.uid=au.id')
            ->where($params)
            ->column('au.id');
    }
}
