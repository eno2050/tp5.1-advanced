<?php

/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/10
 * Time: 14:52
 * Email: 1042080686@qq.com
 */

namespace app\common\model;

use app\common\components\table\CommonTable;

/**
 * Class AuthDepartment
 * @package app\common\model
 */
class AuthDepartmentModel extends Base
{
    protected $autoWriteTimestamp = true;
    protected $table = CommonTable::TB_AUTH_DEPARTMENT;

    /**
     * @param array $params
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDepartmentInfo($params = [])
    {
        return $this->where($params)->find();
    }

    /**
     * @param array $params
     * @param int $page_size
     * @return array|\think\Paginator
     * @throws \think\exception\DbException
     */
    public function getDepartmentList($params = [], $page_size = 20)
    {
        $list = $this->where($params)
            ->order('id DESC')
            ->paginate($page_size);

        return $list;
    }

    /**
     * @param array $params
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllDepartmentList($params = [])
    {
        return $this->where($params)
            ->order('id DESC')
            ->select();
    }

    /**
     * @param array $params
     * @return int
     */
    public function getDepartmentCount($params = [])
    {
        $count = $this->where($params)->count();
        return intval($count);
    }

    /**
     * @param array $params
     * @param string $id
     * @return bool
     */
    public function saveDepartment($params = [], $id = '')
    {
        if (!$id) {
            return $this->allowField(true)->save($params);
        } else {
            $params['update_time'] = time();
            return $this->allowField(true)->save($params, ['id' => $id]);
        }
    }
}