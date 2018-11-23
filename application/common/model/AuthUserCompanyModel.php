<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/11/22
 * Time: 10:54
 * Email: 1042080686@qq.com
 */

namespace app\common\model;

/**
 * 用户关联公司表
 * Class AuthUserCompanyModel
 * @package app\common\model
 */
class AuthUserCompanyModel extends Base
{
    /**
     * @param array $params
     * @param string $fields
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllList($params=[],$fields=''){
        if(!$fields){
            $data = $this->where($params)->order('id DESC')->select();
        }else{
            $data = $this->where($params)->field($fields)->order('id DESC')->select();
        }
        return $data;
    }
}