<?php
namespace app\admin\controller;
class Logout extends AdminBase{
    public function index(){
        session(config("admin.session_user"),null);
        return redirect("userLogin");
    }
}