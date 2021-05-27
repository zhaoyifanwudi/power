<?php
namespace app\admin\controller;

use think\worker\Server;
// use Workerman\Worker;
use app\common\model\mysql\Ip as IpModel;
use app\common\model\mysql\Userip as UseripModel;
class Worker extends Server{
    // protected $vis = array();
    // protected $token;
    // protected $name;
    // public function __construct(){
    //     $this -> token = session(config("admin.token_user"));
    //     $this -> name = session(config("admin.session_user"));
    // }
    protected $socket = 'http://0.0.0.0:2345';
    public function onConnect($connection){
        $ip = $connection -> getRemoteIp();
        
        // array_push($this -> vis,$connection);
        // dump($ip);
        $ipObj = new IpModel;
        $temp = $ipObj -> findIp($ip);
        if(empty($temp)){
            $res = $ipObj -> createIp($ip);
        }
        // dump(json_encode(cache("worker")));
        // $connection -> send(1);
        // dump($worker);
        // $aa = $this -> worker;
        // dump($aa);

    }
    // // public function onWorkerStart($worker){
    // //     $connection -> send(1);
    // // }
    public function onMessage(){
        // $ip = "192.168.20.141";
        // $token = session(config("admin.token_user"));
        // $name = session(config("admin.session_user"));
        // $username = $name['username'];
        // $user = [
        //     'username' => $username,
        //     'token' => $token
        // ];
        // $ress = cache("worker");
        $userip = new UseripModel();
        $useripRes = $userip -> finduserIp();
        
        $usertemp = $useripRes -> username;
        $iptemp = $useripRes -> token;
        $ip = $useripRes -> ip;
        $vis = [
            'username' => $usertemp,
            'token' => $iptemp
        ];
        // $useripRes = $useripRes -> toArray();
        // $ip = $useripRes['ip'];
        // $username = $useripRes['username'];
        // $token = $useripRes['token'];
        foreach($this -> worker -> connections as $connection)
        {
            $temp = $connection -> getRemoteIp();
            
            if($temp == $ip){
                $aaa = $connection -> send(json_encode($vis));
                dump($aaa);
            }
        }   
    }
    public function onClose($connection){
        $ip = $connection -> getRemoteIp();
        $ipObj = new IpModel;
        $userip = new UseripModel();
        $iptemp = $ipObj -> recoverIp($ip);
        $usertemp = $userip -> deleteIp();
    }
}