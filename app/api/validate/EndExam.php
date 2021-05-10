<?php
namespace app\api\validate;
use think\Validate;
class EndExam extends Validate{
    protected $rule = [
        'examid' => 'require',
        // 'score' => 'require'
        'erroroptnum' => 'require',
        'totaltime' => 'require'
    ];
    protected $message = [
        'examid' => '没有训练id',
        // 'score' => '没有分数'
        'erroroptnum' => '误操作次数必须',
        'totaltime' => '时间必须'
    ];
    protected $scene = [
        'examList' => ['examid'],
    ];
}