<?php
namespace app\admin\controller;

use think\facade\View;
use app\BaseController;
use app\common\model\mysql\User as UserModel;
class Login extends AdminBase{
    public function initialize(){
        // parent::initialize();
        if($this -> isLogin()){
            return $this -> redirect("index");
        }
    }
    // public function md(){
    //     dump(session(config("admin.session_user")));
    // }
    public function login(){
        return View::fetch();
    }
    public function check(){
        if(!$this -> request -> isPost()){
            return show(config("status.error"),"请求方式错误");
        }
        $username = $this -> request -> param("username","","trim");
        $password = $this -> request -> param("password","","trim");
        if(empty($username) || empty($password)){
            return show(config("status.error"),"用户名或者密码为空");
        }
        try{
            $userObj = new UserModel();
            $user = $userObj -> getUsername($username);
            
            if(empty($user)){
               
            }
            if($user -> status != config("status.mysql.table_normal")){
                return show(config("status.error"),"账号存在异常");
            }
            $user = $user -> toArray();
            
            if($user['password'] != md5($password."_power")){
                return show(config("status.error"),"密码错误");
            }
            $updateData = [
                "utime" => time(),
            ];
            $userId = $user['id'];
            $res = $userObj -> updateUser($userId,$updateData);
            if(empty($res)){
                return show(config("status.error"),"登陆失败");
            }
            
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,登陆失败");
        }
        session(config("admin.session_user"),$user);
        return show(config("status.success"),"登陆成功");
    }
}