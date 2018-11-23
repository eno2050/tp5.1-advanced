<?php
/**
 * Created by VS Code.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/9
 * Time: 16:19
 * Email: 1042080686@qq.com
 */
namespace app\common\validate;
use think\Validate;

class LoginCheckValid extends Validate{

    protected $rule = [
        'username|用户名'  =>  'require|max:50',
        'password|密码' =>  'require|min:6|max:15',
    ];

    protected $message = [
        'username.require' => '用户名必须',
        'username.max' => '用户名称最多不能超过50个字符',
        'password.require' => '登陆密码必须',
        'password.min' => '登陆密码必须大于6个字符',
        'password.max' => '登陆密码不能超过15个字符',
    ];
}