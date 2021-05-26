<?php
namespace app\common\model\mysql;
use think\Model;
class User extends Model{
    // protected $connection = 'moodle';
    /**
     * 查询用户
     */
    public function getUsername($username){
        if(empty($username)){
            return false;
        }
        $where = [
            "username" => trim($username),
        ];
        $result = $this -> where($where) -> find();
        return $result;
    }
    /**
     * 创建用户
     */
    public function createUser($username,$password){
        if(empty($username) || empty($password)){
            return 0;
        }
        $this -> username = $username;
        $this -> password = md5($password."_power");
        $this -> utime = time();
        $this -> status = 1;
        $result = $this -> save();
        if($result){
            return $this -> id;
        } else {
            return 0;
        }
    }
    /**
     * 更新
     */
    public function updateUser($id,$data){
        $id = intval($id);
        if(empty($id) || empty($data) || !is_array($data)){
            return false;
        }
        $where = [
            "id" => $id,
        ];
        return $this -> where($where) -> save($data);
    }
}