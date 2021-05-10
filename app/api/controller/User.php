<?php
declare(strict_types=1);
namespace app\api\controller;
use app\BaseController;
use app\common\business\User as Userbus;
use app\common\model\mysql\User as UserModel;
class User extends BaseController{
    public function code():object
    {
        if(!$this -> request -> isPost()){
            return show(config("status.error"),"请求方式错误");
        }
        
        $username = input('param.username','','trim');
        $password = input('param.password','','trim');
        $data = [
            'username' => $username,
            'password' => $password,
        ];
        try{
            validate(\app\api\validate\User::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        $result = Userbus::valcode($data);
        // try{
        //     $result = Userbus::valcode($data);
        // } catch (\Exception $e){
        //     return show(config("status.error"),$e -> getMessage());
        // }
        // if($result){
        //     return show(config("status.success"),"登陆成功");
        // } else {
        //     return show(config("status.error"),"登陆失败");
        // }
        return $result;
    }
}