<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Conf;
use app\index\model\Article;

class Common extends Controller
{
	public function _initialize(){//初始化方法
		//栏目导航
		$this->getNevCates();
		//配置项
		$this->getConf();
		//获取文章
		if(input('cateid')){
			$this->getArticles(input('cateid'));
		}elseif (input('artid')) {
			$artres=db('article')->find(input('artid'));
			$cateid=$artres['cateid'];
			$this->getArticles($cateid);
		}
		
	}

	public function getNevCates(){
		$cateres=db('cate')->where('pid',0)->select();
		foreach ($cateres as $key => $v) {
			$children=db('cate')->where('pid',$v['id'])->select();
			if($children){
				$cateres[$key]['children']=$children;
			}else{
				$cateres[$key]['children']=0;
			}
		}
		$this->assign('cateres',$cateres);
	}

	public function getConf(){
		$conf=new Conf;
		$allconf=$conf->getAllConf();
		// dump($allconf);die;
		$confres=array();
		foreach ($allconf as $k => $v) {
			$confres[$v['enname']]=$v['cnname'];
		}
		// dump($confres);die;
		$this->assign('confres',$confres);
		
	}

	public function getArticles($cateid){
		$article=new Article();
		$artRes=$article->getAllArticles(input('cateid'));
		$this->assign('artRes',$artRes);
	}
}