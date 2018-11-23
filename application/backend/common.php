<?php

function getCheckOptions()
{
    return [
        [
            'name' => '待审批',
            'value' => \app\common\util\Constant::STATUS_SUBMITTED,
        ],
        [
            'name' => '已通过',
            'value' => \app\common\util\Constant::STATUS_CHECKED,
        ],
        [
            'name' => '已驳回',
            'value' => \app\common\util\Constant::STATUS_REFUSED,
        ]
    ];
}
