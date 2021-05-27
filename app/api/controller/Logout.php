<?php
namespace app\api\controller;
use app\common\model\mysql\Ip as IpModel;
class Logout extends AuthBase{
    public function index(){
        // $res = cache(config("redis.token_pre").$this -> accessToken,NULL);
        $ipObj = new IpModel();
        $ip = session(config("admin.ip_user"));
        $temp = $ipObj -> recoverIp($ip);
        dump($ip);
        if($temp){
            return show(config("status.success"),"退出成功");
        }
        return show(config("status.error"),"退出登陆失败");
    }
}