<?php
use think\facade\Route;
Route::rule("login","user/code","POST");
Route::rule("logout","logout/index","GET");
Route::rule("train","train/index","GET");
Route::rule("process","train/process","GET");
Route::rule("end","train/endTrain","GET");
Route::rule("trainList","train/trainList","GET");
Route::rule("exam","exam/index","GET");
Route::rule("epro","exam/process","GET");
Route::rule("endExam","exam/endExam","GET");
Route::rule("examList","exam/examList","GET");