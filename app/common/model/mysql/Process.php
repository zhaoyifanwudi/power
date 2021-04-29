<?php
namespace app\common\model\mysql;
use think\Model;
class Process extends Model{
    public function creatProcess($trainid,$stepid,$result,$time){
        $this -> trainid = $trainid;
        $this -> stepid = $stepid;
        $this -> result = $result;
        $this -> time = $time;  
        $result = $this -> save();
        return $result;

    }
}