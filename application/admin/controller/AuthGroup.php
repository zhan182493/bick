<?php
namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\controller\Common;

class AuthGroup extends Common
{
	

	public function lst(){
		$authgroupres=db('auth_group')->select();
		$this->assign('authgroupres',$authgroupres);
		return view();
	}

	
			
	

	public function add(){
		$authRule=new \app\admin\model\AuthRule();
		$authGroup=new AuthGroupModel();
		$addres=$authRule->ruletree();
		// dump($addres);die;
		if(request()->isPost()){
			$data=input('post.');
			$data['rules']=$authGroup->dataRule($data['rules']);
			$data['rules']=implode(',', $data['rules']);
			// dump($data);die;
			if(!isset($data['status'])){
				$data['status']=0;
			}
			if(db('auth_group')->insert($data)){
				$this->success('添加成功！','lst');
			}else{
				$this->error('添加失败!');
			}
			return;
		}
		$this->assign('addres',$addres);
		return view();
	}

	public function edit(){
		$authRule=new \app\admin\model\AuthRule();
		$authGroup=new AuthGroupModel();
		$authRuleRes=$authRule->ruletree();
		$editres=db('auth_group')->find(input('id'));
		$editres['rules']=explode(',', $editres['rules']);
		//接受表单请求
		if(request()->isPost()){
			$data=input('post.');
			$data['rules']=$authGroup->dataRule($data['rules']);
			$data['rules']=implode(',', $data['rules']);

			if(!isset($data['status'])){
				$data['status']=0;
			}

			if(db('auth_group')->update($data)!==false){
				$this->success('修改成功！','lst');
			}else{
				$this->error('修改失败!');
			}
			return;
		}

		$this->assign('editres',$editres);
		$this->assign('authRuleRes',$authRuleRes);
		return view();
	}

	public function del(){
		
		if(db('auth_group')->delete(input('id'))){
			$this->success('删除成功!','lst');
		}else{
			$this->error('删除失败！');
		}
	}
}