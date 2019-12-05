<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Link as LinkModel;

class Link extends Common
{
	public function lst(){
		$linkres=db('link')->paginate(3);
		$this->assign('linkres',$linkres);
		return view();
	}

	public function add(){
		if(request()->isPost()){
			$data=input('post.');
			$validate=\think\Loader::validate('Link');
			if(!$validate->scenc('add')->check($data)){
				$this->error($validate->getError());

			}
			if(db('link')->insert($data)){
				$this->success('添加成功！','link/lst');
			}else{
				$this->error('添加失败！');
			}
		}
		return view();
	}

	public function edit(){
		$id=input('id');
		if(request()->isPost()){
			if(db('link')->update(input('post.'))){
				$this->success('修改成功！','link/lst');
			}else{
				$this->error('修改失败！');
			}
		}
		$links=db('link')->find($id);
		$this->assign('links',$links);
		return view();
	}

	public function del(){
		if(db('link')->delete(input('id'))){
			$this->success('删除成功！','link/lst');
		}else{
			$this->error('删除失败！');
		}
	}
}