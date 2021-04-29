<?php
namespace app\api\controller;
class Logout extends AuthBase{
    public function index(){
        $res = cache(config("redis.token_pre").$this -> accessToken,NULL);
        if($res){
            return show(config("status.success"),"退出成功");
        }
        return show(config("status.error"),"退出登陆失败");
    }
}