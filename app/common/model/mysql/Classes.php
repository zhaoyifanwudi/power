<?php
namespace app\common\model\mysql;
use think\Model;
class Classes extends Model{
    public function queryClass($classid){
        $trainid = intval($classid);
        if(empty($classid)){
            return false;
        }
        $where = [
            "id" => $classid,
        ];
        $classesObj = $this -> where($where) -> find();
        return $classesObj;
    }
    
}