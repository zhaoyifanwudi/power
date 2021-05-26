<?php
namespace app\common\model\mysql;
use think\Model;
class Train extends Model{
    public function process(){
        return $this -> hasMany(Process::class,'trainid');
    }
    public function creatTrain($userid,$classid){
        $this -> userid = $userid;
        $this -> classid = $classid;
        $this -> stime = time();
        $this -> etime = 0;
        $this -> time = 0;
        
        $result = $this -> save();
        $id = $this -> id;
        if($result){
            return $id;
        } else {
            return 0;
        }
    }
    public function updateTrain($trainid){
        $trainid = intval($trainid);
        if(empty($trainid)){
            return false;
        }
        $where = [
            "id" => $trainid,
        ];
        $stime = $this -> where($where) -> find() -> stime;
        // dump($stime);
        $time = time() - $stime;
        $data = [
            "etime" => time(),
            "time" => $time,
            "pass" => 1
        ];
        return $this -> where($where) -> save($data);
    }
    public function queryTrain($trainid){
        $trainid = intval($trainid);
        if(empty($trainid)){
            return false;
        }
        $where = [
            "id" => $trainid,
        ];
        $trainObj = $this -> where($where) -> find();
        // if($trainid -> pass == 1){

        // }
        return $trainObj;
    }
    public function queryProcess($trainid){
        $trainid = intval($trainid);
        if(empty($trainid)){
            return false;
        }
        $where = [
            "trainid" => $trainid,
            "result" => 1,
        ];
        $processObj = $this -> process() -> where($where) -> select();
        return $processObj;
    }
    public function queryTrains($trainid,$pageid){
        $trainid = intval($trainid);
        if(empty($trainid)){
            return false;
        }
        $where = [
            "userid" => $trainid,
        ];
        if($pageid == 1){
            $trainObj = $this -> where($where)  -> where('classid','<=',3) -> select();
        } else if($pageid == 0) {
            $trainObj = $this -> where($where)  -> where('classid','>',3) -> select();
        }
        return $trainObj;
    }
}