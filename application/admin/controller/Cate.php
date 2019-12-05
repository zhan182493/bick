<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Cate extends Common
{

	protected $beforeActionList = [
        // 'first',
        // 'second' =>  ['except'=>'hello'],
        'delsoncate'  =>  ['only'=>'del'],
    ];

	public function lst(){
		$cate=new CateModel;
		$cateres=$cate->catetree();
		$this->assign('cateres',$cateres);
		return view();
	}

	public function add(){
		$cate=new CateModel;
		$cateres=$cate->catetree();

		if(request()->isPost()){
			$data=input('post.');
			////////////
			// 验证器 //
			////////////
			if(db('cate')->insert($data)){
				$this->success('添加成功！','cate/lst');
			}else{
				$this->error('添加失败！');
			}

			return;
		}

		$this->assign('cateres',$cateres);
		return view();
	}

	public function edit(){
		$id=input('id');
		$cate=new CateModel;
		$cateres=$cate->catetree();
		$cates=db('cate')->find($id);
		if(request()->isPost()){
			$data=input('post.');
			///////////
			//验证器 //
			///////////
			if(db('cate')->update($data)){
				$this->success('修改成功！','cate/lst');
			}else{
				$this->error('修改失败！');
			}
			return;
		}

		$this->assign('cateres',$cateres);
		$this->assign('cates',$cates);
		return view();
	}
	
	public function del(){
		// echo "okkk"; die;
		$id=input('id');
		if(db('cate')->delete($id)){
			$this->success('删除成功！','cate/lst');
		}else{
				$this->error('删除失败！');
		}
	}

	public function delsoncate(){
		$id=input('id');
		$cate=new CateModel;
		$sonids=$cate->getchilrenid($id);
		$allcateid=$sonids;
		$allcateid[]=$id;
		// dump($allcateid);die;
		//循环删除栏目下的文章
		foreach ($allcateid as $k => $v) {
			$article=new ArticleModel;
			$article->where(array('cateid'=>$v))->delete();
		}
		

		//删除所有子栏目
		if($sonids){
			db('cate')->delete($sonids);
		}
	}
	
}