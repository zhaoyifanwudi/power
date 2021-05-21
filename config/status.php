<?php
/**
 * 状态码配置
 */
return [
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "pass_error" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,

    "mysql" => [
        "table_normal" => 1,//正常
        "table_pedding" => 0,//待审
        "table_delete" => 99,//删除
    ],
    // "login" => [
    //     "create" => 2,
    //     "login" => 1,
    // ],
    
];