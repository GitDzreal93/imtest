<?php

//默认消息发送者
//$fromUids = array(
//		2002431296,//纪律委员18800000088
//		2003739988,//学生1 滑石粉 18700000125
//		2003741012，//学生2 热猫 18700000127
//		2003742036，//学生3 佛语 18700000128
//		2003731796，//主讲老师 18700000127
//		); 

//默认消息发送群组
//$toGroupIds = array(18, 23, 27);

//消息发送类型 文本1001，普通表情1001，图片1002,语音1003，老师表情1007
//$msgContent = array();
//$msgContent = array(
//		10011 => array(
//			'msgType'    => 1001,
//			'msgContent' => '666666',
//			),
//		10012 => array(
//			'msgType'    => 1001,
//			'msgContent' => '',
//			),
//
//		1002 => array(
//			'msgType'    => 1002,
//			'msgContent' => '',
//		    ),
//		1003 => array(
//			'msgType'    => 1003,
//			'msgContent' => '',
//		    ),
//		1007 => array(
//			'msgType'    => 1007,
//			'msgContent' => '',
//		    ),
//		);


function log($data){

	   $log_file = '/home/homework/user/huangdazhen/script/MSG/log'.date('Ymd',time()).'_msg.log';
	   $arrData = explode(",",$data)
	   $content = $arrData[0] . "\t" . $arrayData[1] . "\t" . $arryData[3] . "\r\n";
	   file_put_contents($log_file,$content, FILE_APPEND);
}

?>
