<?php
namespace app\api\validate;
use think\Validate;
class EndTrain extends Validate{
    protected $rule = [
        'trainid' => 'require',
    ];
    protected $message = [
        'trainid' => '没有训练id',
    ];
    protected $scene = [
        
    ];
}