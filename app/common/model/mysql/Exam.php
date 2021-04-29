<?php
namespace app\common\model\mysql;
use think\Model;
class Exam extends Model{
    public function epro(){
        return $this -> hasMany(Epro::class,'examid');
    }
    public function findExamByUser($userid,$classid){
        $userid = intval($userid);
        $classid = intval($classid);
        if(empty($userid) || empty($classid)){
            return false;
        }
        $where = [
            "userid" => $userid,
            "classid" => $classid
        ];
        $res = $this -> where($where) -> find();
        if($res){
            return false;
        }
        return true;
    }
    public function creatExam($userid,$classid){
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
    public function updateExam($examid,$score){
        $examid = intval($examid);
        $score = intval($score);
        if(empty($examid) || empty($score)){
            return false;
        }
        $where = [
            "id" => $examid,
        ];
        $stime = $this -> where($where) -> find() -> stime;
        // dump($stime);
        $time = time() - $stime;
        if($score > 60){
            $data = [
                "etime" => time(),
                "time" => $time,
                "score" => $score,
                "pass" => 1
            ];
        } else{
            $data = [
                "etime" => time(),
                "time" => $time,
                "score" => $score,
                "pass" => 0
            ];
        }
        return $this -> where($where) -> save($data);
    }
    public function queryExam($examid){
        $trainid = intval($examid);
        if(empty($examid)){
            return false;
        }
        $where = [
            "id" => $examid,
        ];
        $examObj = $this -> where($where) -> find();
        // if($trainid -> pass == 1){

        // }
        return $examObj;
    }
    public function queryEpro($examid){
        $trainid = intval($examid);
        if(empty($examid)){
            return false;
        }
        $where = [
            "examid" => $examid,
            "result" => 1,
        ];
        $eproObj = $this -> epro() -> where($where) -> select();
        return $eproObj;
    }
}