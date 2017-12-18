<?php

namespace Admin\Controller;

use Think\Controller;

/*
 * Ajax 控制器
 */

class AjaxController extends Controller {

    //二级联动 获取栏目列表
    public function get_column() {
        $classify_id = I("classify_id");
        $columns = M("column")->where("classify_id=" . $classify_id)->select();
        $this->ajaxReturn(array("data" => $columns));
    }

}
