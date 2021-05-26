<?php
namespace app\admin\controller;

use think\worker\Server;
use app\common\model\mysql\Ip as IpModel;
class Worker extends Server{
    protected $socket = 'http://0.0.0.0:2345';
    public function onConnect($connection){
        $ip = $connection -> getRemoteIp();
        // dump($ip);
        $ip = $ip;
        $ipObj = new IpModel;
        $temp = $ipObj -> findIp($ip);
        if(empty($temp)){
            $res = $ipObj -> createIp($ip);
        }
        
        // dump($res);

    }
    public function onMessage($connection,$data){
        // $temp = json_decode($data);
        // dump($temp);
        // if(!empty($data)){
        //     $ip = $data -> ip;
        //     $ipObj = new IpModel;
        //     $res = $ipObj -> createIp($ip);
        // }
    }
    public function onClose($connection){

    }
}