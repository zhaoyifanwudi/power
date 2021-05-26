<?php
namespace app\admin\controller;

use think\facade\View;
use app\common\model\mysql\Exam as ExamModel;
use app\common\model\mysql\Classes as ClassesModel;
class ArExam extends AdminBase{
    public function arexam(){
        return View::fetch();
    }
    public function getSession(){
        $gets = session(config("admin.session_user"));
        return $gets['id'];
    }
    public function arexamList(){
        $pageid = 0;
        $ExamObj = new ExamModel();
        $clasObj = new ClassesModel();
        $temp = $this -> getSession();
        $eproRes = $ExamObj -> queryExams($temp,$pageid);
        foreach($eproRes as $k => $v){
            $v -> authorityId = 1;
            $v -> parentId = -1;
            $v -> menuIcon = "layui-icon-set";
            $clasRes = $clasObj -> queryClass($v -> classid);
            $v -> classid = $clasRes -> name;
            $v -> stime = date("Y-m-d H:i:s",$v -> stime);
            unset($v -> id);
            unset($v -> userid);
            unset($v -> etime);
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