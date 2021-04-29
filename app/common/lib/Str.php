<?php
namespace app\common\lib;
class Str{
    public static function getLoginToken($string){
        $str = md5(uniqid(md5(microtime(true)),true));
        $token = sha1($str.$string);
        return $token;
    }
}