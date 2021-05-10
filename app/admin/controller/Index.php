<?php
namespace app\admin\controller;

use think\facade\View;
use app\BaseController;
class Index extends AdminBase{
    public function index(){
        $gets = session(config("admin.session_user"));
        $name = $gets['username'];
        return View::fetch("index",['name' => $name]);
    }
}