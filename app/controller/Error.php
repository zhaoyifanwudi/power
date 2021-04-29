<?php
namespace app\controller;
class Error{
    public function __call($name,$arguments)
    {
        $result = [
            'status' => config("status.controller_not_found"),
            'message' => "找不到该控制器",
            'result' => null,
        ];
        return json($result,400);
    }
}