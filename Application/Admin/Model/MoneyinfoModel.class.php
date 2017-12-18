<?php
namespace Admin\Model;
use Think\Model;

class MoneyinfoModel extends Model {
    
    public function moneytype(){
        return array(
            '1' => '推荐',
            '2' => '赠送',
			'3' => '其他',
        );
    }
    
}