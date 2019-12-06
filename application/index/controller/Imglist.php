<?php
namespace app\index\controller;
use app\index\controller\Common;
use app\index\model\Article;

class Imglist extends Common
{
	public function imglist(){
		$article=new Article();
		$artRes=$article->getAllArticles(input('cateid'));
		$this->assign('artRes',$artRes);
		return view();	
	}

}