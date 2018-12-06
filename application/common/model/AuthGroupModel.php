<?php

/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/27
 * Time: 12:35
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\model;

use app\common\components\table\CommonTable;

class AuthGroupModel extends Base
{
    protected $autoWriteTimestamp = true;
    protected $table = CommonTable::TB_AUTH_GROUP;
    /**
     * @param array $params
     * @param int $page_size
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getGroupList($params = [], $page_size = 10)
    {
        $result = $this->where($params)
            ->order('id ASC')
            ->paginate($page_size);

        return $result;
    }

    /**
     * @param array $params
     * @return int
     */
    public function getGroupCount($params = [])
    {
        $count = $this->where($params)->count();
        return intval($count);
    }

    /**
     * @param array $params
     * @return array|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGroupInfo($params = [])
    {
        $info = $this->where($params)->find();
        return $info ? $info : [];
    }

    /**
     * @param array $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllGroupList($params = [])
    {
        $result = $this->where($params)
            ->order('id ASC')
            ->select();

        return $result;
    }

    /**
     * @param array $params
     * @param string $id
     * @return bool
     */
    public function saveGroup($params = [], $id = '')
    {
        if (!$id) {
            return $this->allowField(true)->save($params);
        } else {
            $params['update_time'] = time();
            return $this->allowField(true)->save($params, ['id' => $id]);
        }
    }
}