<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate;
use app\admin\model\Article as ArticleModel;

class Article extends Common
{
	public function lst(){
		$lstres=db('cate')->alias('c')->join('article a','a.cateid=c.id')->paginate(10);
		$this->assign('lstres',$lstres);
		return view();
	}

	public function add(){
		$cate=new Cate;
		$cateres=$cate->catetree();
		if(request()->isPost()){
			$data=input('post.');
            $data['time']=time();
			// dump($data); die;
			
			$article=new ArticleModel;


			if($article->save($data)){
				return $this->success('添加成功！','article/lst');
			}else{
				return $this->error('添加失败！');
			}

			return;
		}

		$this->assign('cateres',$cateres);
		return view();
	}
	
	public function edit(){
		$id=input('id');
		$editres=db('article')->find($id);
		$cate=new Cate;
		$cateres=$cate->catetree();

		if(request()->isPost()){
			$data=input('post.');
			$article=new ArticleModel;
			$res=$article->update($data);
			if($res){
				return $this->success('修改成功！','article/lst');
			}else{
				return $this->error('修改失败！');
			}
			return;
		}

		$this->assign('arts',$editres);
		$this->assign('cateres',$cateres);
		return view();
	}

	public function del(){
		$id=input('id');
		$delres=ArticleModel::destroy($id);
		if($delres){
			return $this->success('删除成功！','article/lst');
		}else{
			return $this->error('删除失败！');
		}
	}
}