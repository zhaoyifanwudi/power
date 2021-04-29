<?php
namespace app\common\model\mysql;
use think\Model;
class Step extends Model{
    public function querynum($classid){
        $trainid = intval($classid);
        if(empty($classid)){
            return false;
        }
        $where = [
            "classid" => $classid,
        ];
        $stepObj = $this -> where($where) -> select();
        return $stepObj;
    }
}