<?php

/**
 * Created by PhpStorm.
 * User: Dzreal_93
 * Date: 2017/10/16
 * Time: 23:32
 */

Bd_Init::init('im');

require_once('imtest/TestLog/IMTest_Log.php');
class IMTest_Talk2Send
{
    /**
     * MQS消息实例
     * @var Service_Page_Basic_SendMessage
     */
    public function __construct()
    {
        $this->objSendMessage = new Service_Page_Basic_SendMessage();
        $this->objLog = new IMTest_Log();
    }

    //发消息方法($filePath透传给IMTest_Log的imLog)
    public function sendMsg($filePath,$arrInput){
		$arrOutput = $this->objSendMessage->execute($arrInput);
        //日志包装及处理
        $arrLogs = $arrOutput;
        $arrLogs['atUids'] = isset($arrInput['atUids'])?$arrInput['atUids']:0;
        $ret = 'message send succeed!';
        $arrLogs['ret'] = $ret;
        $this->objLog->imLog($filePath,$arrLogs);
        return $ret;
    }
}

/*
//单元测试脚本，正式启用时删除
$objTalk2Send = new IMTest_Talk2Send();
$filePath = '/home/homework/user/huangdazhen/script/im/IMTest/TestLog/log/Msg_log/';
$arrInput = array(
		'uid' => 2003712320,
		'toUid' => 0,
		'toGroupId' => 128,
		'productId' => -1,
		'cuid' => '263D3A4ABA4D19548062A2B39E3243EE|47487095800099',
		'msgType' => 1001,
		//'msgType' => 1002,
		//'msgType' => 1003,
		'msgContent' => '[生气]',
		//'msgContent' => '{"height":1280,"pid":"qa_f5506e905f7738991c2c692ded174e0a","width":720}',
		//'msgContent' => '{"voiceId":"2592","voiceLen":2536,"voiceSize":1714}',
);
$objTalk2Send->sendMsg($filePath,$arrInput);
*/
