<?php

/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/16
 * Time: 10:33
 * Email: 1042080686@qq.com
 */

namespace app\common\model;


use app\common\util\table\CommonTable;

class AuthLoginLogModel extends Base
{
    protected $table = CommonTable::TB_LOGIN_LOG;

    /**
     * @param $params
     * @return bool
     */
    public function addLog($params)
    {
        $params['create_time'] = time();

        return $this->allowField(true)->save($params);
    }

}