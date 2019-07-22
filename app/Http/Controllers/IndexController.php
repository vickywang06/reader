<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
	private $apiurl='http://iscore.top/reader/public/v1/';
	private $cateurl='http://img.xcvf.top/home/cate.json';
	private $rankurl='http://img.xcvf.top/home/rank.json';


	//首页（小说分类）
	public function index(){
		$catelist=getremotedata($this->cateurl);
		foreach($catelist as $k=>$v){
			//$burl=substr($v['file_url'],0,-6).'1.json';//获取第一页的书籍，前10本
			//$catelist[$k]['booklist']=getremotedata($burl);
		}
		//v($catelist);
		return view('index.index',[
			'catelist'=>$catelist,
			'navtype'=>1
		]);
	}
	//分类详情（小说列表）
	public function booklist(Request $request){
        $catename=$request->catename;
        $page=$request->page;
		$detaillist=getapidata($this->apiurl,array('service'=>'Book.Search','keyword'=>$catename,'type'=>101,'page'=>$page?:1));
		$pagehtml=pagination(1000,$page,100);
		$catelist=getremotedata($this->cateurl);
		//v($catelist);
		//面包屑导航
		$breadcrumbarr=array(
			array(
				'url'=>'index/index',
				'title'=>'首页',
				'is_end'=>0
			),
			array(
				'url'=>'',
				'title'=>$catename.'小说',
				'is_end'=>1
			),
		);
		return view('index.booklist',[
			'title'=>$catename,
			'breadcrumbarr'=>$breadcrumbarr,
			'detaillist'=>$detaillist,
			'catename'=>$catename,
			'catelist'=>$catelist,
			'pagehtml'=>$pagehtml
		]);
	}
	//排行榜
	public function ranklist(){
		$ranklist=getremotedata($this->rankurl);
		v($ranklist);
		$title='排行榜单';
		//面包屑导航
		$breadcrumbarr=array(
			array(
				'url'=>'index/index',
				'title'=>'首页',
				'is_end'=>0
			),
			array(
				'url'=>'',
				'title'=>$title,
				'is_end'=>1
			),
		);
		return view('index.ranklist',[
			'ranklist'=>$ranklist,
			'title'=>$title,
			'navtype'=>2
		]);
	}
}
