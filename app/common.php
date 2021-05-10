<?php
// 应用公共文件
/**
 * 通用API设置
 */
function show($status,$message = "error",$data = [],$httpStatus = 200)
{
    if(empty($data)){
        $data = new \ArrayObject();
    }
    $result = [
        "status" => $status,
        "message" => $message,
        "result" => $data,
    ];
    return json($result,$httpStatus);
}