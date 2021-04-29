<?php
namespace app\api\controller;
use app\common\model\mysql\Exam as ExamModel;
use app\common\model\mysql\Epro as EproModel;
use app\common\model\mysql\Question as QuestionModel;
class Exam extends AuthBase{
    public function index(){
        $classid = input('param.classid','');
        $data = [
            "classid" => $classid,
        ];
        try{
            validate(\app\api\validate\Exam::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        $userInfo = cache(config("redis.token_pre").$this -> accessToken);
        try{
            $examObj = new ExamModel();
            $isres = $examObj -> findExamByUser($userInfo['id'],$classid);
            if(!$isres){
                return show(config("status.error"),"您已经参与过当前科目的考核");
            }
            $res = $examObj -> creatExam($userInfo['id'],$classid);
            if(!$res){
                return show(config("status.error"),"开启考核失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,开启考核失败");
        }
        return show(config("status.success"),"开启考核成功",["examid" => $res]);
    }
    public function process(){
        $examid = input('param.examid','');
        $questionid = input('param.questionid','');
        $result = input('param.result','');
        $time = input('param.time','');
        $data = [
            'examid' => $examid,
            'questionid' => $questionid,
            'result' => $result,
            'time' => $time
        ];
        try{
            validate(\app\api\validate\epro::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $eproObj = new EproModel();
            $res = $eproObj -> creatEpro($examid,$questionid,$result,$time);
            if(!$res){
                return show(config("status.error"),"此题目提交失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,此题目提交失败");
        }
        return show(config("status.success"),"此题目提交成功");
    }
    public function endExam(){
        $examid = input('param.examid','');
        $score = input('param.score','');
        $data = [
            "examid" => $examid,
            "score" => $score
        ];
        try{
            validate(\app\api\validate\EndExam::class) -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $examObj = new ExamModel();
            $res = $examObj -> updateExam($examid,$score);
            if(!$res){
                return show(config("status.error"),"结束考核失败");
            }
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,结束考核失败");
        }
        return show(config("status.success"),"结束考核");
    }
    public function examList(){
        $examid = input('param.examid','');
        $data = [
            "examid" => $examid,
        ];
        try{
            validate(\app\api\validate\EndExam::class) -> scene('examList') -> check($data);
        }catch (\think\exception\ValidateException $e){
            return show(config("status.error"),$e -> getError());
        }
        try{
            $ExamObj = new ExamModel();
            $questionObj = new QuestionModel();
            $examRes = $ExamObj -> queryExam($examid);
            $eproRes = $ExamObj -> queryEpro($examid);
            $eproRes = $eproRes -> toArray();
            $eproNum = count($eproRes);
            $questionRes = $questionObj -> querynum($examRes -> classid);
            $questionRes = $questionRes -> toArray();
            $questionNum = count($questionRes);
            $accuracy = number_format($eproNum / $questionNum,2);
        } catch(\Exception $e){
            return show(config("status.error"),"内部异常,获取训练结果失败");
        }
        return show(config("status.success"),"获取训练结果成功",["time" => $examRes -> time,"accuracy" => $accuracy,"score" => $examRes -> score]);
    }
}