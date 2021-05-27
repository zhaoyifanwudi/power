<?php
namespace app\admin\controller;

use think\facade\View;
use app\admin\controller\Worker;
use app\common\model\mysql\Ip as IpModel;
use app\common\model\mysql\Userip as UseripModel;
class RunOther extends AdminBase{
    public function runother(){
        return View::fetch();
    }
    public function getAll(){
        $ipObj = new IpModel();
        $res = $ipObj -> getAllIp();
        foreach($res as $k => $v){
            $v -> authorityId = 1;
            $v -> parentId = -1;
            $v -> menuIcon = "layui-icon-set";
            $v -> token = session(config("admin.token_user"));
            $name = session(config("admin.session_user"));
            $v -> username = $name['username'];
            unset($v -> id);
            unset($v -> status);
            unset($v -> time);
        }
        $temp = [
            "code" => 0,
            "msg" => "",
            "count" => count($res),
            "data" => $res
        ];
        return json($temp);
    }
    public function checkIp(){
        $ip = $this -> request -> param("ip","","trim");
        $ipObj = new IpModel();
        $res = $ipObj -> checkIp($ip);
        if($res){
            return show(config("status.error"),"ip已经被占用");
        } else {
            $temp = $ipObj -> updateIp($ip);
            if($temp){
                session(config("admin.ip_user"),$ip);
                $token = session(config("admin.token_user"));
                $name = session(config("admin.session_user"));
                $username = $name['username'];
                // $temp = [
                //     'ip' => $ip,
                //     'username' => $username,
                //     'token' => $token
                // ];
                // $ress = cache("worker",$temp);
                $useripObj = new UseripModel();
                $useridRes = $useripObj -> updateIp($username,$ip);
                // $worker = new Worker();
                // $tepp = $worker -> onMessage();
                return show(config("status.success"),"启动成功");
            } else {
                return show(config("status.error"),"启动失败");
            }
        }
    }
    public function md(){
        $userip = new UseripModel();
        $useripRes = $userip -> finduserIp();
        dump($useripRes);
    }
}