<?php
use think\facade\Route;
Route::rule("userLogin","Login/login","GET");
Route::rule("index","Index/index","GET");
// Route::rule("md","Login/md","GET");
// Route::rule("md","AdminBase/getSession","GET");
Route::rule("vrtrain","VrTrain/vrtrain","GET");
Route::rule("vrtrainList","VrTrain/vrtrainList","GET");
Route::rule("vrexam","VrExam/vrexam","GET");
Route::rule("vrExamList","VrExam/vrexamList","GET");
Route::rule("logout","Logout/index","GET");
Route::rule("loginCheck","Login/check","POST");