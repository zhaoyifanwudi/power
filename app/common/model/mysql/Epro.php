<?php
namespace app\common\model\mysql;
use think\Model;
class Epro extends Model{
    public function creatEpro($examid,$questionid,$result,$time){
        $this -> examid = $examid;
        $this -> questionid = $questionid;
        $this -> result = $result;
        $this -> time = $time;  
        $result = $this -> save();
        return $result;
    }
}