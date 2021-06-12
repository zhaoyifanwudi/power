<?php
namespace app\admin\controller;

use think\facade\View;
use app\common\model\mysql\Train as TrainModel;
use app\common\model\mysql\Classes as ClassesModel;
class ArTrain extends AdminBase{
    public function artrain(){
        return View::fetch();
    }
    public function getSession(){
        $gets = session(config("admin.session_user"));
        return $gets['id'];
    }
    public function artrainList(){
        $pageid = 0;
        $examObj = new TrainModel();
        $clasObj = new ClassesModel();
        $temp = $this -> getSession();
        $eproRes = $examObj -> queryTrains($temp,$pageid);
        // dump($eproRes);
        foreach($eproRes as $k => $v){
            $v -> authorityId = 1;
            $v -> parentId = -1;
            $v -> menuIcon = "layui-icon-set";
            $clasRes = $clasObj -> queryClass($v -> classid);
            $v -> classid = $clasRes -> name;
            $v -> stime = date("Y-m-d H:i:s",$v -> stime);
            $v -> etime = date("Y-m-d H:i:s",$v -> etime);
            unset($v -> id);
            unset($v -> userid);
        }
        $temp = [
            "code" => 0,
            "msg" => "",
            "count" => count($eproRes),
            "data" => $eproRes
        ];
        return json($temp);
    }
}