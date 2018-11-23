<?php

/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/27
 * Time: 14:52
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\model;

use app\common\util\table\CommonTable;

class AuthGroupAccessModel extends Base
{
    protected $table = CommonTable::TB_AUTH_GROUP_ACCESS;

    /**
     * @param array $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserGroupAccessInfo($params = [])
    {
        return $this->alias('aga')
            ->field('ag.*,aga.uid')
            ->join('tb_auth_group ag', 'ag.id=aga.group_id', 'left')
            ->where($params)
            ->find();
    }
}