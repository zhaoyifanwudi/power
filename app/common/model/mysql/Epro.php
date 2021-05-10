<?php
namespace app\common\model\mysql;
use think\Model;
class Epro extends Model{
    public function creatEpro($examid,$question,$result,$time){
        $this -> examid = $examid;
        $this -> question = $question;
        $this -> result = $result;
        $this -> time = $time;  
        $result = $this -> save();
        return $result;
    }
}