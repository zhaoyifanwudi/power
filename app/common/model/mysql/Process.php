<?php
namespace app\common\model\mysql;
use think\Model;
class Process extends Model{
    public function creatProcess($trainid,$step,$result,$time){
        $this -> trainid = $trainid;
        $this -> step = $step;
        $this -> result = $result;
        $this -> time = $time;  
        $result = $this -> save();
        return $result;

    }
}