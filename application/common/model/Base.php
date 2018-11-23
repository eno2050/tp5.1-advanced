<?php

namespace app\common\model;

use think\Model;

class Base extends Model
{
    protected $dateFormat = 'Y-m-d H:i';

    public function getItem($id)
    {
        return $this->field('*')->find($id);
    }

    public function getItems($conditions  =[], $paginate = true, $listRows = 10)
    {
        $result = $this->field('*');

        if ($conditions) {
            $result = $result->where($conditions);
        }

        if ($listRows < 5 || $listRows > 20) {
            $listRows = 10;
        }

        $result = $result->order('id', 'DESC');

        if ($paginate) {
            return $result->paginate($listRows);
        } else {
            return $result->select();
        }
    }


}
