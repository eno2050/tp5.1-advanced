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

class AuthPositionModel extends Base
{
    protected $autoWriteTimestamp = true;
    protected $table = CommonTable::TB_AUTH_POSITION;

    /**
     * @param array $params
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPositionInfo($params = [])
    {
        return $this->where($params)->find();
    }

    /**
     * @param array $params
     * @param int $page_size
     * @return array|\think\Paginator
     * @throws \think\exception\DbException
     */
    public function getPositionList($params = [], $page_size = 20)
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
    public function getAllPositionList($params = [])
    {
        return $this->where($params)
            ->order('id DESC')
            ->select();
    }

    /**
     * @param array $params
     * @return int
     */
    public function getPositionCount($params = [])
    {
        $count = $this->where($params)->count();
        return intval($count);
    }

    /**
     * @param array $params
     * @param string $id
     * @return bool
     */
    public function savePosition($params = [], $id = '')
    {
        if (!$id) {
            return $this->allowField(true)->save($params);
        } else {
            $params['update_time'] = time();
            return $this->allowField(true)->save($params, ['id' => $id]);
        }
    }
}