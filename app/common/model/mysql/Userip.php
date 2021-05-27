<?php
namespace app\common\model\mysql;
use think\Model;
class Userip extends Model{
    public function createIp($username,$token){
        if(empty($username) ||empty($token)){
            return false;
        }
        $where = [
            "id" => 1,
        ];
        $data = [
            "username" => $username,
            "token" => $token
        ];
        $ipObj = $this -> where($where) ->save($data);
        return $ipObj;
    }
    public function updateIp($username,$ip){
        if(empty($username) || empty($ip)){
            return false;
        }
        
        $where = [
            "username" => $username,
        ];
        $data = [
            "ip" => $ip,
        ];
        $ipObj = $this -> where($where) -> save($data);
    }
    public function finduserIp(){
        // $where = [
        //     "id" => 1,
        // ];
        $result = $this -> where('id','>',0) -> find();
        return $result;
    }
    public function deluserIp($token){
        $where = [
            "token" => $token,
        ];
        $data = [
            "username" => "",
            "token" => "",
            "ip" => ""
        ];
        return $this -> where($where) -> save($data);
    }
    public function deleteIp(){
        $where = [
            'id' => 1,
        ];
        $data = [
            'ip' => "",
        ];
        return $this -> where($where) -> save($data);
    }
}