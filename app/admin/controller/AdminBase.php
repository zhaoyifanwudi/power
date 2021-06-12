<?php
namespace app\admin\controller;
use app\BaseController;
use think\exception\HttpResponseException;
use app\common\model\mysql\Epro as EproModel;
class AdminBase extends BaseController{
    public $user = null;
    public function initialize(){
        parent::initialize();
        //
        if(empty($this -> isLogin())){
            return $this -> redirect("userLogin",302);
        }
    }
    public function isLogin(){
        $this -> user = session(config("admin.session_user"));
        // dump($this->user);
        if(empty($this -> user)){
            return false;
        }
        return true;
    }
    public function redirect(...$args){
        throw new HttpResponseException(redirect(...$args));
    }

    public function convertObj(){
        
    }
    public function covertEpro($id){
        $eproObj = new EproModel();
        $eprotemp = $eproObj -> findByid($id);
        foreach ($eprotemp as $k => $v) {
            $v -> authorityId = 0;
            $v -> parentId = $id;
            $v -> menuIcon = "layui-icon-set";
            // $clasRes = $v -> question;
            $v -> classid = $v -> question;
            $v -> stime = "--";
            $v -> pass = $v -> result;
            $v -> erroroptnum = "--";
            // $v -> time = date("Y-m-d H:i:s",$v -> time);
            $v -> id = 0;
            // $v -> isMenu = 0;
            // $v -> checked = 0;
            // unset($v -> userid);
            // unset($v -> etime);
        }
        return $eprotemp;
    }
}