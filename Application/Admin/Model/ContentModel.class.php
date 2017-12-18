<?
namespace Admin\Model;
use Think\Model;

class ContentModel extends Model {
	
	//获取内容分类
	/*
	 * return array
	 */
	public function get_classtype(){
		return array(
			'1'=>'单页文章',
			'2'=>'问答文章',
			'3'=>'新闻文章',
		);
	}
}