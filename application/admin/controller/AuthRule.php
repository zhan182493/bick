<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroup as AuthGroupModel;
class AuthRule extends Common
{

	protected $beforeActionList=[
		'delsons'=>['only'=>'del']
	];

	public function lst(){
		$authrule=new AuthRuleModel;
		$ruletree=$authrule->ruletree();
		$lstres=$ruletree;
		$this->assign('lstres',$lstres);
		return view();
	}

	public function add(){
		$authrule=new AuthRuleModel;
		$addres=$authrule->ruletree();
		if(request()->isPost()){
			$data=input('post.');
			
			if(db('auth_rule')->insert($data)){
				$this->success('添加成功！','lst');
			}else{
				$this->error('添加失败！');
			}
		}
		$this->assign('addres',$addres);
		return view();
	}

	public function edit(){
		$authrule=new AuthRuleModel;
		$ruletree=$authrule->ruletree();
		$id=input('id');
		if(request()->isPost()){
			$res=db('auth_rule')->update(input('post.'));
			if($res!==false){
				$this->success('修改成功！','lst');
			}else{
				$this->error('修改失败！');
			}
		}
		$editres=db('auth_rule')->find($id);
		$this->assign('editres',$editres);
		$this->assign('ruletree',$ruletree);
		return view();
	}

	public function del(){
		if(db('auth_rule')->delete(input('id'))){
			$this->success('删除成功！','lst');
		}else{
			$this->error('删除失败！');
		}
	}

	public function delsons(){
		$authrule=new AuthRuleModel;
		$sonids=$authrule->getchildids(input('id'));	
		AuthRuleModel::destroy($sonids);
	}
}