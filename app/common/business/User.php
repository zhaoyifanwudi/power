<?php
declare(strict_types=1);
namespace app\common\business;
use app\common\model\mysql\User as UserModel;
use app\common\lib\Str;
class User{
    public static function valcode(array $data):object{
        try{
            $userObj = new UserModel();
            $user = $userObj -> getUsername($data['username']);
            
            if(empty($user)){
                $cuser = $userObj -> createUser($data['username'],$data['password']);
                if($cuser){
                    $token = Str::getLoginToken($data['username']);
                    $redisData = [
                        "id" => $cuser,
                        "username" => $data['username'], 
                    ];
                    $res = cache(config("redis.token_pre").$token,$redisData);
                    // return true;
                    return show(config("status.success"),"新用户创建成功",["token" => $token,"username" => $data['username']]);
                }
            }
            if($user -> status != config("status.mysql.table_normal")){
                // throw new Exception("账号存在异常");
                return show(config("status.error"),"账号存在异常");
            }
            $user = $user -> toArray();
            if($user['password'] != md5($data['password']."_power")){
                // throw new Exception("密码错误");
                return show(config("status.error"),"密码错误");
            }
            $updateData = [
                "utime" => time(),
            ];
            $userId = $user['id'];
            $res = $userObj -> updateUser($userId,$updateData);
            if(empty($res)){
                // throw new Exception("登陆失败");
                return show(config("status.error"),"登陆失败");
            }
        } catch(\Exception $e){
            // throw new Exception("内部异常,登陆失败");
            return show(config("status.error"),"内部异常,登陆失败");
        }
        $token = Str::getLoginToken($data['username']);
        $redisData = [
            "id" => $userId,
            "username" => $data['username'], 
        ];
        $res = cache(config("redis.token_pre").$token,$redisData);
        // return true;
        return show(config("status.success"),"登陆成功",["token" => $token,"username" => $data['username']]);
    }
}