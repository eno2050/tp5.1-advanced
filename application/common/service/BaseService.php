<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/10/09
 * Time: 14:10
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\service;

use think\facade\Config;

class BaseService
{
    public function returnMsg($Code='0',$Msg='',$Data=[]){
        if (!empty($Msg))
        {
            $responseMsg = $Msg;
        }
        else
        {
            $responseMsg = '请求成功';
            if ($Code !== '0')
            {
                $responseMsg = empty($Msg) ? Config::get('code.' . $Code) : $Msg;
            }
        }
        if(!$Data){
            $Data = new \ArrayObject();
        }
        $result = array(
            'Code'=>$Code,
            'Msg'=>$responseMsg,
            'Data'=>$Data,
        );
        return $result;
    }
}