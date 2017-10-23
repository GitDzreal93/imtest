<?php
//im群消息发送脚本，需要更改部分字段，比如uid toGroupId等
// author:huangdazhen
 
Bd_Init::init("im");

$objMessage = new Service_Data_Message();
$objUser = new Hk_Ds_Fudao_IMUser();
$objUserGroup = new Hk_Ds_Fudao_IMUserGroup();

//后续接入发送不同消息类型,待开发中
//include '/home/homework/user/huangdazhen/script/MSG/util.php';

$arrInput = array(
	'uid'        => 0,
	'toUid'      => 0,
	'toGroupId'  => 0,
	'msgType'    => 0,
	'msgContent' => '',
		);

//默认消息发送者 param1
$arrInput['uid'] = 2002431296;

//toUid无效 param2

//默认消息发送群(填Group_ID) param3
$arrInput['toGroupId'] = 23;


if(isset($argv[2]) && !empty($argv[2])){
    $arrInput['uid'] = $argv[2];
}
	    
if(isset($argv[3]) && !empty($argv[3])){
    $arrInput['toGroupId'] = $argv[3];
}


if(isset($argv[1]) && $argv[1] == "--help"){
    echo "使用方法：\n" . "1、修改 36行 41行的uid(发消息者的uid)和toGroupId(发消息的群) \n" . "2.1、采用默认uid和默认toGroupId去发消息，n代表发n条消息 \n" . "\t php pushMsg.php n \n" . "2.2、假如不采用默认uid和默认toGroupId，则采用 \n" . "\t php pushMsg.php n uid toGroupId \n" . "如有问题，自己解决 \n";
	exit(0);
}


//消息类型: 文本1001，表情1001，语音1003，图片1004，老师表情1007 param4
$arrInput['msgType'] = 1001;


//消息内容 param5 (适用于单条消息发送)
//$msgContent = '111111';
//$arrInput['msgContent'] = $msgContent;

//at用户 param6
$atUids = '';

//获取单条msgId以及存redis-kv
//$msgData = $objMessage->makeMessage($arrInput['uid'], intval($arrInput['toUid']), intval($arrInput['toGroupId']), intval($arrInput['msgType']), strval($arrInput['msgContent']),$atUids);

echo $arrInput['toUid'];
//获取用户信息
$toUserInfo = $objUser->getIMUserDetail(intval($arrInput['toUid']));
//获取群成员列表
$groupUserList = $objUserGroup->getIMGroupUserListForSendMsg(intval($arrInput['toGroupId']));
//遍历接收者，取uid以及设置pushStatus
foreach ($groupUserList as $uidData) {
	if(intval($uidData['uid']) >= 0 && intval($uidData['uid']) !== intval($arrInput['uid'])){
		$toUidList[] = intval($uidData['uid']);
		$toUidListPushStatus[] = 0;
	}   
}   

var_export($toUidList);
$pushTitle = '作业帮班级群';
$pushContent = '你的班级群有新消息啦';

//发送一条消息
//$ret = $objMessage->sendMessage(intval($msgData['msg_id']), $toUidList,($groupDetail['type'] == Hk_Ds_Fudao_IMGroup::TYPE_PRIVATE_CHAT || in_array($groupUserDetail['roleId'], Hk_Ds_Fudao_IMUserGroup::$ADMINISTRATORS_MAP)) ? Service_Data_Message::MSG_CLEAN_TYPE_STABLE : Service_Data_Message::MSG_CLEAN_TYPE_VOLATILE,$toUidListPushStatus, $pushTitle, $pushContent);


//发送多条消息
$max = $argv[1];

//日志方法
function msgLog($data){
	$log_file = '/home/homework/user/huangdazhen/script/im/batchPushMsgSync/pushMsg/log/'.date('Ymd',time()).'_msg.log';
	$arrData = explode("*",$data);
	$content = "发送人：" .$arrData['0'] . "\t" . "消息id：" . $arrData['1'] . "\t" . "消息内容：" . $arrData['2'] . "\t" . "发送时间：" . $arrData['3'] . "\t" . "result:" . $arrData['4'] . "【失败：0，成功：1】" . "\r\n";
	file_put_contents($log_file,$content, FILE_APPEND);
}   


for($i=1;$i<=$max;$i++){
    $arrInput['msgContent'] = strval($i);
	$msgData = $objMessage->makeMessage($arrInput['uid'], intval($arrInput['toUid']), intval($arrInput['toGroupId']), intval($arrInput['msgType']), strval($arrInput['msgContent']),$atUids);
	usleep(500000);
	$stime = date('Y-m-d H:i:s',time());
    $ret = $objMessage->sendMessage(intval($msgData['msg_id']), $toUidList,($groupDetail['type'] == Hk_Ds_Fudao_IMGroup::TYPE_PRIVATE_CHAT || in_array($groupUserDetail['roleId'], Hk_Ds_Fudao_IMUserGroup::$ADMINISTRATORS_MAP)) ? Service_Data_Message::MSG_CLEAN_TYPE_STABLE : Service_Data_Message::MSG_CLEAN_TYPE_VOLATILE,$toUidListPushStatus, $pushTitle, $pushContent);	
    
	$logdata = $arrInput['uid'] . "*" .$msgData['msg_id'] . "*" . $i . "*" . $stime . "*" . $ret;
	
	msgLog($logdata);

	//输出到控制台
//	echo "\n" . $i . "\t" . $stime . "\t";
//	var_dump($ret);
//	echo "\n";

	usleep(500000);

}

?>
