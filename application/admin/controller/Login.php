<?php
namespace app\admin\controller;
use think\Controller;


class Login extends Controller
{
	public function login(){
		if(request()->isPost()){
			
			if(!captcha_check(input('code'))){
				$this->error('验证码错误！');
			}
			$res=db('admin')->where('username',input('username'))->find();
			if($res){
				if($res['password']==md5(input('password'))){
					session('id',$res['id']);
					session('username',$res['username']);
					$this->success('登录成功！正在跳转...','index/index');
				}
			}else{
				$this->error('用户名或密码错误！');
			}
			return;
		}
		return view();
	}

	public function out(){
		session(null);
		$this->success('退出成功，正在跳转...','login/login');
	}
}