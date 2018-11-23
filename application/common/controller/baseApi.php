<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/10/09
 * Time: 14:10
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\controller;


use think\Controller;
use think\facade\Config;
use think\response\Json;

/**
 * Class baseApi
 * @package app\common\controller
 */
class BaseApi extends Controller
{

    /**
     * @param string $Code
     * @param string $Msg
     * @param array $Data
     * @return \think\Response
     */
    protected function jsonResponse($Code = '0', $Msg = '', $Data = [])
    {
        if (!empty($Msg))
        {
            $responseMsg = $Msg;
        }
        else
        {
            $responseMsg = '成功';
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
            'Data'=>$Data
        );
        return \json($result);
    }
}