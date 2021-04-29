<?php
/**
 * API的base(不需要登录)
 */
namespace app\api\controller;
use app\BaseController;
use think\exception\HttpResponseException;
class ApiBase extends BaseController{
    public function initialize(){
        parent::initialize();
    }
    public function show(...$args){
        throw new HttpResponseException(show(...$args));
    }
}