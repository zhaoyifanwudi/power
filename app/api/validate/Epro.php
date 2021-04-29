<?php
namespace app\api\validate;
use think\Validate;
class Epro extends Validate{
    protected $rule = [
        'examid' => 'require',
        'questionid' => 'require',
        'result' => 'require',
        'time' => 'require',
    ];
    protected $message = [
        'examid' => '考核id必须',
        'questionid' => '题目id必须',
        'result' => '结果必须',
        'time' => '时间必须',
    ];
    protected $scene = [
        
    ];
}