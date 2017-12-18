<?php

namespace Home\Controller;

use Think\Controller;

class WeixinController extends Controller {
	/**
     * 初始化
     */
	var $Weixin;
    public function _initialize()
    {
		vendor('WxpayAPI.WxPayConfig');
        $this->Weixin = new \Org\Util\Weixin;
    }

	//默认首页
    public function index() {
		$echoStr = trim(I("echostr"));
		if ($echoStr) {
			//验证
			$this->Weixin->valid();
		}else{
			//接受消息，并做相应
			$this->responseMsg();
		}		
    }

	//用户登录处理
	public function wxlogin(){
		$referee=I("referee");
	
		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
		$jsApi = new \JsApiPay();
		$userinfo = $jsApi->GetUserinfoU();
		if(!$userinfo['openid']){
			header("Location:".WEB_HOST."index.php/home/weixin/wxlogin/referee/".$referee);
			exit();
		}	

		//过滤昵称中emoji
		$userinfo['nickname'] = $this->filterEmoji($userinfo['nickname']);
		//$userinfo['nickname'] = preg_replace('~\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]~', '', $userinfo['nickname']);
		$user=M("User")->where("openid='".$userinfo['openid']."'")->find();
		
		if($user){//用户已经注册过了
			//更新昵称以及头像信息
			if($userinfo['sex']==1){$sex="男";}elseif($userinfo['sex']==2){$sex="女";}else{$sex="保密";}
			M("User")->where("openid='".$userinfo['openid']."'")->save(array("nickname"=>$userinfo['nickname'],"avatar"=>$userinfo['fileurl'],"sex"=>$sex));
			if($userinfo['subscribe']==0){ //判断用户是否关注公众号
				//跳转关注公众号页面				
			     header("Location:".U('index/attention'));
				 exit();
			}else{
				session("user_id", $user['user_id']);
			}
		}else{
			//创建用户时直接将推荐人id写入
			$referee_info = M("user")->where('user_id='.intval($referee))->find();
			$referee_id=$referee_info['user_id']?$referee_info['user_id']:0;

			//先注册
			if($userinfo['sex']==1){$sex="男";}elseif($userinfo['sex']==2){$sex="女";}else{$sex="保密";}	
			$user_id=M("User")->add(array("openid"=>$userinfo['openid'],"nickname"=>$userinfo['nickname'],"avatar"=>$userinfo['fileurl'],"sex"=>$sex,'refree_id'=>$referee_id,'addtime'=>SYS_TIME));
			
			if($userinfo['subscribe']==0){ //判断用户是否关注公众号
				//跳转关注公众号页面				
				header("Location:".U('index/attention'));
				exit();
			}
		}

		/*
		//获取带参数二维码
		$fileurl = $jsApi->sceneqrcode("QR_SCENE",session("user_id"));
		//合成特定二维码
		$pathinfo = pathinfo($fileurl);
		$basename=$pathinfo['basename'];
		if(is_file(THINK_PATH . '../uploadfile/qrcode/'.$basename)){
			$newfile=format_qrcode($basename,'qrcode_background.png',220,70,40);
		}
		*/
		//跳转到首页
		header("Location:".U('index/index',array("referee"=>$referee)));
		exit();
	}
	
	//发送模板消息
	public function sendtemplate(){
		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
		$jsApi = new \JsApiPay();
		$data='{
		  "touser": "oUFYs1t0S-ts6M1hB-V1knxZntD4",
		  "template_id": "CpzzJotELZnCYa0t57g1zgG6y8JtQpxeyyfAYNo-NxU",
		  "url": "www.baidu.com",
		  "data":{
			  "course_name": {
				"value": "专题名称专题名称专题名称",
				"color": "#173177"
			  },
			  "course_money": {
				"value": "专题价格专题价格专题价格",
				"color": "#173177"
			  },
			  "course_parts": {
				"value": "更新信息更新信息更新信息",
				"color": "#173177"
			  },
			  "course_retime": {
				"value": "更新时间更新时间更新时间",
				"color": "#173177"
			  },
			  "course_speaker": {
				"value": "主讲老师主讲老师主讲老师",
				"color": "#173177"
			  }
			}
		}';
		$jsApi->sendtemplate($data);
		return true;
	}

	//接受消息
	public function responseMsg(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$postStr = $postStr?$postStr:file_get_contents("php://input");
		$this->Weixin->logger("接受消息到的消息为：".$postStr);
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
			$this->Weixin->logger("接受消息，消息类型为：".$RX_TYPE);

            switch($RX_TYPE){
                case "text":
                    $resultStr = $this->Weixin->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->Weixin->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "未知类型消息: ".$RX_TYPE;
                    break;
            }
			$this->Weixin->logger("回应消息，消息为：".$resultStr);
            echo $resultStr;
        }else{
            echo "Error";
            exit;
        }
    }

	// 过滤掉emoji表情
	function filterEmoji($str)
	{
		$str = preg_replace_callback(
		'/./u',
		function (array $match) {
			return strlen($match[0]) >= 4 ? "" : $match[0];
		},
		$str);
		return $str;
	}

}
