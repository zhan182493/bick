<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{
	public function _initialize(){
		if(!session('id')||!session('username')){
			$this->error('请先登录','login/login');
		}

		$auth=new Auth();
		$request=Request::instance();
		$con=$request->controller();
		$action=$request->action();
		$name=$con.'/'.$action;
		$notCheck=array('Index/index','Admin/lst','Cate/lst','Conf/lst','AuthGroup/lst','AuthRule/lst','Link/lst');
		if(session('id')!==1){//如果不是超级管理员就验证
			if(!in_array($name,$notCheck)){//不在免验证数组里面就验证
				// dump($name);die;
				if(!$auth->check($name,session('id'))){
					$this->error('没有权限!','index/index');
				}
			}
		}
	}
}
	