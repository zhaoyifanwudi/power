<?php
namespace app\admin\controller;
use app\BaseController;
use think\exception\HttpResponseException;
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
}