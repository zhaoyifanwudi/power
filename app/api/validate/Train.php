<?php
namespace app\api\validate;
use think\Validate;
class Train extends Validate{
    protected $rule = [
        'classid' => 'require',
    ];
    protected $message = [
        'classid' => '没有选择科目',
    ];
    protected $scene = [
        
    ];
}