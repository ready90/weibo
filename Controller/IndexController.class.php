<?php
//命名空间
namespace Home\Controller;// Home 命名空间
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$login=empty($_SESSION['user'])?0:1;
		$user=empty($_SESSION['user'])?'登录':$_SESSION['user'];
		$mysql=M('atricle');
		$reviews=M('reviews');
		$message=$mysql->where('is_del="1"')->limit(2)->order('id desc')->select();
		if($message){
			foreach($message as $k=>$v){
			$tmp=$reviews->where('aid="'.$v['id'].'"')->order('id desc')->select();
			$message[$k]['reviews']=$tmp;
			}
		}
		$this->assign('message',$message);
		$this->assign('login',$login);
		$this->assign('user',$user);
		$this->display('index');
    }
	public function login(){
		if($_POST){
			$user=trim($_POST['user']);
			$password=$_POST['password'];
			$login=new \Home\Model\LoginModel;
			$rs=$login->login($user,$password);
			if($rs===true){
				session('user',$user);  
				header('location:'. U('Index/index'));
				exit;
			}else{
				echo '<script>';
				echo 'alert("'.$rs.'")';
				echo '</script>';
			}
		}
	}
	public function loginout(){
		session('user',null); 
		header('location:'. U('Index/index'));
		exit;
	}
}