<?php
namespace app\api\validate;
use think\Validate;
class EndExam extends Validate{
    protected $rule = [
        'examid' => 'require',
        'score' => 'require'
    ];
    protected $message = [
        'examid' => '没有训练id',
        'score' => '没有分数'
    ];
    protected $scene = [
        'examList' => ['examid'],
    ];
}