<?php
namespace app\api\validate;
use think\Validate;
class Process extends Validate{
    protected $rule = [
        'trainid' => 'require',
        'step' => 'require',
        'result' => 'require',
        'time' => 'require',
    ];
    protected $message = [
        'trainid' => '训练id必须',
        'step' => '步骤id必须',
        'result' => '结果必须',
        'time' => '时间必须',
    ];
    protected $scene = [
        
    ];
}