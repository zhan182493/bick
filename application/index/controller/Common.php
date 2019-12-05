<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Conf;

class Common extends Controller
{
	public function _initialize(){
		//初始化方法
		$conf=new Conf;
		$allconf=$conf->getAllConf();
		// dump($allconf);die;
		$confres=array();
		foreach ($allconf as $k => $v) {
			$confres[$v['enname']]=$v['cnname'];
		}
		// dump($confres);die;
		$this->assign('confres',$confres);
		$this->getNevCates();
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
}