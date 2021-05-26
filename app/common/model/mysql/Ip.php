<?php
namespace app\common\model\mysql;
use think\Model;
class Ip extends Model{
    public function createIp($ip){
        if(empty($ip)){
            return false;
        }
        $this -> ip = $ip;
        $this -> status = 1;
        $this -> time = time();
        $ipObj = $this -> save();
        return $ipObj;
    }
    public function findIp($ip){
        if(empty($ip)){
            return false;
        }
        $where = [
            "ip" => $ip,
        ];
        $result = $this -> where($where) -> find();
        return $result;
    }
    public function getAllIp(){
        $res = $this -> select();
        return $res;
    }
    public function checkIp($ip){
        if(empty($ip)){
            return false;
        }
        $where = [
            "ip" => $ip,
        ];
        $result = $this -> where($where) -> find();
        if($result -> status == 0){
            return true;
        } else {
            return false;
        }
    }
    public function updateIp($ip){
        if(empty($ip)){
            return false;
        }
        $where = [
            "ip" => $ip,
        ];
        $data = [
            "status" => 0,
        ];
        return $this -> where($where) -> save($data);
    }
}