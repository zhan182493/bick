<?php
namespace app\index\controller;
use app\index\controller\Common;

class Index extends Common
{
	public function index(){

		$this->lunBo();
		$this->newArt();
		$this->hotArt();
		$this->linkRes();
		return view();
	}

	public function lunBo(){
		$lunBo=db('article')->where('rec',1)->limit(4)->select();
		return $this->assign('lunBo',$lunBo);
	}

	public function newArt(){
		$newArt=db('cate')->alias('c')->join('article a','c.id=a.cateid')->where('a.id','not in',[34,35,36])->order('a.time desc')->limit(8)->select();
		// dump($newArt);die;
		return $this->assign('newArt',$newArt);
	}

	public function hotArt(){
		$hotArt=db('article')->where('id','not in',[34,35,36])->order('click desc')->limit(5,5)->select();
		return $this->assign('hotArt',$hotArt);
	}

	public function linkRes(){
		$linkRes=db('link')->select();
		return $this->assign('linkRes',$linkRes);
	}
}