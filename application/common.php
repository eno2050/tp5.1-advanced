<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 添加用户salt
 *
 * @param int $length 长度，默认为4，不能超过13位
 * @param boolean $has_letter 是否包含字母
 * @return string
 */
function generate_salt($length = 4, $has_letter = false)
{
    $salt = '';

    if ($has_letter) {
        $length = -intval($length);
        $salt = substr(uniqid(), $length);
    } else {
        for ($i = 0; $i < $length; $i++) {
            $salt .= mt_rand(0, 9);
        }
    }

    return $salt;
}

/**
 * 生成业务单编号
 * @param null $orderNo
 * @param string $prefix
 * @param int $batchNoLength
 * @return string
 */
function generate_order_no($orderNo = null, $prefix = 'RK', $batchNoLength = 4) {
    // 本月，直接加一，非本月，从 00001 开始记数
    if (empty($orderNo)) {
        return $prefix . date('Ym') . str_pad(1, $batchNoLength, '0', STR_PAD_LEFT);
    } else {
        if (empty($prefix)) {
            $prefix = mb_substr($orderNo, 0, 2);
        }

        $orderNoBody = mb_substr($orderNo, 2);
        $orderNoYm = mb_substr($orderNo, 2, 6);
        $Ym = date('Ym');

        if ($Ym == $orderNoYm) {
            return $prefix . bcadd($orderNoBody, 1, 0);
        } else {
            return $prefix . $Ym . str_pad(1, $batchNoLength, '0', STR_PAD_LEFT);
        }
    }
}

/**
 * 生成业务单货物的批次号
 * @param $orderNo
 * @param string $lastBatchNo
 * @return string
 */
function generate_batch_no($orderNo, $lastBatchNo = '') {
    if (empty($lastBatchNo)) {
        return $orderNo . '0001';
    } else {
        return $orderNo . str_pad(bcadd(mb_substr($lastBatchNo, mb_strlen($orderNo)), 1, 0), 4, '0', STR_PAD_LEFT);
    }
}