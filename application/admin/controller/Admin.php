<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Admin as AdminModel;


class Admin extends Common
{
	public function lst(){
		// static $grouptitle=array();
		$auth=new Auth();
		$adminres=db('admin')->paginate(5);
		foreach ($adminres as $k => $v) {
			$groups=$auth->getGroups($v['id']);
			if($groups){
				$groupsTitle=$groups[0]['title'];
			$v['grouptitle']=$groupsTitle;
			}
			$lstres[]=$v;
		}
		// dump($lstres);die;
		
		$this->assign('lstres',$lstres);
		$this->assign('adminres',$adminres);
		return view();
	}

	public function add(){
		$authGroupRes=db('auth_group')->select();
		if(request()->isPost()){
			$data=[
				'username'=>input('username'),
				'password'=>md5(input('password')),
			];	

			//验证器
			$admin=new AdminModel();

			// $addres=db('admin')->insert($data);
			if($admin->save($data)){
				$groupAccess['uid']=$admin->id;
				$groupAccess['group_id']=input('group_id');
				if(db('auth_group_access')->insert($groupAccess)!==false){
					return $this->success('添加成功！','admin/lst');
				}else{
				return $this->error('添加失败！');
				}
			}
			return;
		}
		$this->assign('authGroupRes',$authGroupRes);
		return view();
	}
	
	public function edit(){
		$authGroupRes=db('auth_group')->select();
		$id=input('id');
		$editres=db('admin')->find($id);
		$groupAccess=db('auth_group_access')->where('uid',$id)->find();
		if(request()->isPost()){
			$data=[
				'username'=>input('username'),
				'password'=>input('password')
			];
			$groupid=input('group_id');
			$admin=new AdminModel;
			$res=$admin->adminedit($data,$id);
			if($res==1){
				$accessres=db('auth_group_access')->where('uid',$id)->update(array('group_id'=>$groupid));
				if($accessres!==false){
					return $this->success('修改成功！','admin/lst');
				}else{
				return $this->error('修改失败！');
				}	
			}
		}
		
		$this->assign('editres',$editres);
		$this->assign('authGroupRes',$authGroupRes);
		$this->assign('groupAccess',$groupAccess);
		return view();
	}

	public function del(){
		$id=input('id');
		$delres=db('admin')->delete($id);
		if($delres){
			return $this->success('删除成功！','admin/lst');
		}else{
			return $this->error('删除失败！');
		}
	}

	
}