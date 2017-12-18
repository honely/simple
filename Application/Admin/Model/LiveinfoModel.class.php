<?php
namespace Admin\Model;
use Think\Model;

class LiveinfoModel extends Model {
    

    public function liveflag(){
    
        return array(
            '2' => '<font color="red">开启</font>',
            '1' => '关闭'
        );
    }
    
}