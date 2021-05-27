<?php
namespace app\admin\controller;
use app\common\model\mysql\Userip as UseripModel;
class Logout extends AdminBase{
    public function index(){
        $userip = new UseripModel();
        $token = session(config("admin.token_user"));
        $useripRes = $userip -> deluserIp($token);
        session(config("admin.session_user"),null);
        session(config("admin.token_user"),null);
        
        
        return redirect("userLogin");
    }
}