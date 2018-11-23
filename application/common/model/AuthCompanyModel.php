<?php

/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/11/22
 * Time: 10:54
 * Email: 1042080686@qq.com
 */

namespace app\common\model;


use app\common\util\table\CommonTable;
use think\model\concern\SoftDelete;

/**
 * 公司表
 * Class AuthCompanyModel
 * @package app\common\model
 */
class AuthCompanyModel extends Base
{
    use SoftDelete;

    protected $table = CommonTable::TB_AUTH_COMPANY;

    protected $autoWriteTimestamp = true;

    protected $deleteTime = 'delete_time';

    protected $defaultSoftDelete = 0;

    /**
     * @param array $params
     * @param string $fields
     * @param int $page_size
     * @return array|\think\Paginator
     * @throws \think\exception\DbException
     */
    public function getPageList($params = [], $fields = '', $page_size = 20)
    {
        if (!$fields) {
            $data = $this->where($params)->order('id DESC')->paginate($page_size);
        } else {
            $data = $this->where($params)->field($fields)->order('id DESC')->paginate($page_size);
        }
        return $data;
    }

    /**
     * @param array $params
     * @param string $fields
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllList($params = [], $fields = '')
    {
        if (!$fields) {
            $data = $this->where($params)->order('id DESC')->select();
        } else {
            $data = $this->where($params)->field($fields)->order('id DESC')->select();
        }
        return $data;
    }

    /**
     * @param array $params
     * @param string $fields
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getInfo($params = [], $fields = '')
    {
        if (!$fields) {
            $data = $this->where($params)->find();
        } else {
            $data = $this->where($params)->field($fields)->find();
        }
        return $data ? $data : [];
    }

    /**
     * @param array $params
     * @param null $id
     * @return bool
     */
    public function toSave($params = [], $id = null)
    {
        if ($id !== null) {
            return $this->allowField(true)->save($params, ['id' => $id]);
        } else {
            return $this->allowField(true)->save($params);
        }
    }
}