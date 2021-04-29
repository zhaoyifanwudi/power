<?php
namespace app\api\validate;
use think\Validate;
class User extends Validate{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];
    protected $message = [
        'username' => '用户名必须',
        'password' => '密码必须',
    ];
    protected $scene = [
        
    ];
}