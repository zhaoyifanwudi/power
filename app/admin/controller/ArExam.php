<?php
namespace app\admin\controller;

use think\facade\View;
use app\common\model\mysql\Exam as ExamModel;
use app\common\model\mysql\Classes as ClassesModel;
use app\common\model\mysql\Epro as EproModel;
class ArExam extends AdminBase{
    // protected $tempArr = new Array();
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
        $eproRes = $ExamObj -> queryExams($temp,$pageid) -> toArray();
        foreach($eproRes as $k => $v){
            if($v['id'] != 0){
                $v['authorityId'] = $v['id'];
                
                $v['parentId'] = -1;
                $v['menuIcon'] = "layui-icon-set";
                $clasRes = $clasObj -> queryClass($v['classid']);
                $v['classid'] = $clasRes -> name;
                $v['stime'] = date("Y-m-d H:i:s",$v['stime']);
                // $v['isMenu'] = 0;
                // $v['checked'] = 0;
                $eprotemp = $this -> covertEpro($v['id']) -> toArray();
                foreach ($eprotemp as $k1 => $v1) {
                    array_push($eproRes,$v1);
                }
                $eproRes[$k] = $v;
                // unset($v -> id);
                // unset($v -> userid);
                // unset($v -> etime);
            }
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