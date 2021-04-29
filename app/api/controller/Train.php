<?php
namespace app\api\controller;
use app\common\model\mysql\Train as TrainModel;
use app\common\model\mysql\Process as ProcessModel;
use app\common\model\mysql\Step as StepModel;
class Train extends AuthBase{
    public function index(){
        $classid = input('param.classid','');
        $data = [
            "classid" => $classid,
        ];
        try{
            validate(\app\api\validate\Train::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        $userInfo = cache(config("redis.token_pre").$this -> accessToken);
        try{
            $trainObj = new TrainModel();
            $res = $trainObj -> creatTrain($userInfo['id'],$classid);
            if(!$res){
                return show(config("status.error"),"开启训练失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,开启训练失败");
        }
        return show(config("status.success"),"开启训练成功",["trainid" => $res]);
    }
    public function process(){
        $trainid = input('param.trainid','');
        $stepid = input('param.stepid','');
        $result = input('param.result','');
        $time = input('param.time','');
        $data = [
            'trainid' => $trainid,
            'stepid' => $stepid,
            'result' => $result,
            'time' => $time
        ];
        try{
            validate(\app\api\validate\process::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $processObj = new ProcessModel();
            $res = $processObj -> creatProcess($trainid,$stepid,$result,$time);
            if(!$res){
                return show(config("status.error"),"此步骤失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,此步骤失败");
        }
        return show(config("status.success"),"此步骤成功完成");
    }
    public function endTrain(){
        $trainid = input('param.trainid','');
        $data = [
            "trainid" => $trainid,
        ];
        try{
            validate(\app\api\validate\EndTrain::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $trainObj = new TrainModel();
            $res = $trainObj -> updateTrain($trainid);
            if(!$res){
                return show(config("status.error"),"结束训练失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,结束训练失败");
        }
        return show(config("status.success"),"结束训练");
    }
    public function trainList(){
        $trainid = input('param.trainid','');
        $data = [
            "trainid" => $trainid,
        ];
        try{
            validate(\app\api\validate\EndTrain::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $trainObj = new TrainModel();
            $stepObj = new StepModel();
            $trainRes = $trainObj -> queryTrain($trainid);
            $processRes = $trainObj -> queryProcess($trainid);
            $processRes = $processRes -> toArray();
            $processNum = count($processRes);
            $stepRes = $stepObj -> querynum($trainRes -> classid);
            $stepRes = $stepRes -> toArray();
            $stepNum = count($stepRes);
            $accuracy = number_format($processNum / $stepNum,2);
            // dump($accuracy);
            // foreach($stepRes as $k => $v){
            //     dump($v -> id);
            // }

        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,获取训练结果失败");
        }
        return show(config("status.success"),"获取训练结果成功",["time" => $trainRes -> time,"accuracy" => $accuracy]);
    }
}