<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Conf as ConfModel;

class Conf extends Common
{
	public function lst(){
		$confres=db('conf')->paginate(5);
		$this->assign('confres',$confres);
		return view();
	}

	public function add(){
		if(request()->isPost()){
			$data=input('post.');
			if($data['values']){
				$data['values']=str_replace('，',',',$data['values']);
			}
			///////////
			//验证器 //
			///////////
			if(db('conf')->insert($data)){
				$this->success('添加成功！','conf/lst');
			}else{
				$this->error('添加失败！');
			}
		}
		return view();
	}

	public function edit(){
		$confres=db('conf')->find(input('id'));
		if(request()->isPost()){
			$data=input('post.');
			if($data['values']){
				$data['values']=str_replace('，',',',$data['values']);
			}
			$conf=new ConfModel;
			$save=$conf->save($data,['id'=>$data['id']]);
			if($save){
				$this->success('修改成功！','conf/lst');
			}else{
				$this->error('修改失败！');
			}
		}
		$this->assign('confs',$confres);
		return view();
	}

	public function del(){
		if(db('conf')->delete(input('id'))){
			$this->success('删除成功！','conf/lst');
		}else{
			$this->error('删除失败！');
		}
	
	}

	public function conf(){
		$confres=db('conf')->order('sort desc')->select();
		if(request()->isPost()){
			$data=input('post.');
			if($data){
				if(!isset($data['code'])){
					$data['code']='否';
				}
				if(!isset($data["comment"])){
					$data['comment']='否';
				}
				// dump($data);die;
				foreach ($data as $k => $v) {
					db('conf')->where('enname',$k)->update(['





						'=>$v]);
				}
				$this->success('修改成功！');
			}	
			
			return;
		}
		$this->assign('confres',$confres);
		return view();
	}
}