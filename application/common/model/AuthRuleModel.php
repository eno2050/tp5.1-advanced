<?php

/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/27
 * Time: 12:35
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\model;;


use app\common\util\table\CommonTable;
use think\Db;

class AuthRuleModel extends Base
{
    protected $table = CommonTable::TB_AUTH_RULE;

    public function getGroupRule($params = [])
    {
        $subQuery = $this->table(CommonTable::TB_AUTH_GROUP)
            ->alias('hag')
            ->join(CommonTable::TB_AUTH_GROUP_ACCESS . ' haga', 'haga.group_id=hag.id', 'LEFT')
            ->where($params)->field('hag.rules')->find();
        $data['id'] = explode(',', $subQuery['rules']);
        $data['status'] = 1;
        $list = $this->where($data)->order('sort DESC, id ASC')->select();
        return $list;
    }

    /**
     * @param array $params
     * @param string $fields
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRuleInfo($params = [], $fields = '')
    {
        if (!$fields) {
            $rule = $this->where($params)->find();
        } else {
            $rule = $this->where($params)->field($fields)->find();
        }

        return $rule ? $rule : [];
    }

    /**
     * @param array $params
     * @param string $fields
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllAuthRule($params = [], $fields = '')
    {
        $params['status'] = 1;

        if ($fields) {
            $list = $this->where($params)
                ->field($fields)
                ->order('sort DESC, id ASC')
                ->select()
                ->toArray();
        } else {
            $list = $this->where($params)
                ->order('sort DESC, id ASC')
                ->select()->toArray();
        }
        return $list ? $list : [];
    }

    /**
     * @param array $params
     * @param string $id
     * @return bool
     */
    public function saveRule($params = [], $id = '')
    {
        if (!$id) {
            return $this->allowField(true)->save($params);
        } else {
            return $this->allowField(true)->save($params, ['id' => $id]);
        }
    }
    /**
     * @param $userID
     * @param $route
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkAuthRule($userID, $route)
    {
        $groupAccess = Db::table(CommonTable::TB_AUTH_GROUP_ACCESS)->field('*')->where('uid', $userID)->find();
        $rule = Db::table(CommonTable::TB_AUTH_RULE)->field('*')->where('name', $route)->find();
        $groupInfo = Db::table(CommonTable::TB_AUTH_GROUP)->field('*')->where('id', $groupAccess['group_id'])->find();

        $ruleIDs = explode(',', $groupInfo['rules']);
        if (!in_array($rule['id'], $ruleIDs)) {
            return false;
        }
        return true;
    }
}