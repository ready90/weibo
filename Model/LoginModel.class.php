<?php
//命名空间
namespace Home\Model;// Home 命名空间
use Think\Model;
class LoginModel {
    public function login($user,$password){
		$db=M('admin');
		$reg='/^[a-zA-Z]{1}\w{4,14}$/';
		$tmp=preg_match($reg,$user);
		if(!$tmp){
			return '账号格式错误！';
		}
		$reg='/^\w{5,15}$/';
		$tmp=preg_match($reg,$password);
		if(!$tmp){
			return '密码格式错误！';
		}
		echo $user;
		$tmp=$db->field('name,password')->where('name="'.$user.'"')->find();
		if(!$tmp){
			return '账号不存在';
		}
		if($tmp['password']!=md5($password)){
			return '密码不正确';
		}else{
			return true;
		}
    }
}