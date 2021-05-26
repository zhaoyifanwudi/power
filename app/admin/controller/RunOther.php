<?php
namespace app\admin\controller;

use think\facade\View;
use app\common\model\mysql\Ip as IpModel;
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
            show(config("status.error"),"ip已经被占用");
        } else {
            $temp = $ipObj -> updateIp($ip);
            if($temp){
                show(config("status.success"),"启动成功");
            } else {
                show(config("status.error"),"启动失败");
            }
        }
    }
}