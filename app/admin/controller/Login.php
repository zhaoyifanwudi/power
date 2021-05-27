<?php
namespace app\admin\controller;

use think\facade\View;
use app\BaseController;
use app\common\model\mysql\User as UserModel;
use app\common\lib\Str;
use app\common\model\mysql\Userip as UseripModel;
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
                return show(config("status.error"),"用户不存在");
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
        $token = Str::getLoginToken($username);
        $redisData = [
            "id" => $userId,
            "username" => $username, 
        ];
        $res = cache(config("redis.token_pre").$token,$redisData);
        session(config("admin.session_user"),$user);
        session(config("admin.token_user"),$token);
        try{
            $userip = new UseripModel();
            $useripRes = $userip -> createIp($username,$token);
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,登陆失败");
        }
        return show(config("status.success"),"登陆成功");
    }
    public function register(){
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
            if($userObj -> getUsername($username)){
                return show(config("status.error"),"该用户名已存在");
            }
            $user = $userObj -> createUser($username,$password);
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,登陆失败");
        }
        try{
            $userInfo = $userObj -> getUsername($username);
            $userInfo = $userInfo -> toArray();
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,登陆失败");
        }
        $token = Str::getLoginToken($username);
        $redisData = [
            "id" => $user,
            "username" => $username, 
        ];
        $res = cache(config("redis.token_pre").$token,$redisData);
        session(config("admin.session_user"),$userInfo);
        session(config("admin.token_user"),$token);
        try{
            $userip = new UseripModel();
            $useripRes = $userip -> createIp($username,$token);
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,登陆失败");
        }
        return show(config("status.success"),"注册成功");
    }
}