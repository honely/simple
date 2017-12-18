<?php
namespace Admin\Controller;
use Think\Controller;
//系统登录控制器828
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class LoginController extends Controller {

	function __construct() {
		//继承父类
		parent::__construct();
    }

	//空方法，防止报错
	public function _empty(){
        $this->login();
    }
	
	//登录页面
    public function login(){
		if (IS_POST){
			$username=I("username");
			$password=I("password");
			$flag=D("admininfo")->adminlogin($username,$password);
			if($flag){
				$this->success('登录成功！',U('index/index'),3);
			}else{
				$this->error('账号或密码有误，请联系管理员！',U('login/login'),3);
			}
		}else{
			$this->display();
		}
    }

	//退出系统
	public function loginout(){
		session('admin',null);
		header("Content-Type:text/html;charset=utf-8");
		echo("<script>top.location.href='index.php?m=admin&c=login&a=login';</script>");
		exit();
		//$this->success('退出登录成功！',U('login/login'),3);
    }
}