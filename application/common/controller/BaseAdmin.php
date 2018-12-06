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
use think\facade\Request;

/**
 * Class baseAdmin
 * @package app\common\controller
 */
class BaseAdmin extends Controller
{
    protected $middleware = ['auth'];

    /**
     * 页面渲染
     * @param string $template_file
     * @param array $data
     * @return \think\response\View
     */
    protected function loadFrame($template_file = '',$data=[]) {
        $request = Request::instance();
        $common = [
            'menuList'=> $request->menuList,
            'curr_parent_menu'=> $request->curr_parent_menu,
            'curr_menu'=> $request->curr_menu,
            'curr_path'=> $request->curr_path,
            'user'=> $request->user
        ];
        if(is_array($data) && count($data)>0){
            $common = array_merge($common,$data);
        }
        return view($template_file,$common);
    }
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


    protected function getBooleanOptions()
    {
        return [
            [
                'name' => '是',
                'value' => 1
            ],
            [
                'name' => '否',
                'value' => 2
            ]
        ];
    }
}