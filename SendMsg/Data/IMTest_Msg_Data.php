<?php

/**
 * Created by PhpStorm.
 * User: Dzreal_93
 * Date: 2017/10/16
 * Time: 22:00
 */
class IMTest_Msg_Data
{

    public function __construct()
    {
        //发送频率选项 固定频率发送：0 ，随机频率发送：1
        $this->frequency = [
            'is_constant_frequency' => 0,
            'is_random_frequency' => 1,
        ];

        //发送消息策略 只发单一消息类型：0 ， 随机消息类型发送：1 ， 指定消息类型遍历发送：2
        $this->sendStrategy = [
            'singleType' => 0,
            'randomType' => 1,
            'moreType' => 2,
        ];

        //文本：1001 ，图片：1002 ， 语音：1003 ， GIF：1007
        $this->msgType = [
            'txt' => 1001,
            'pic' => 1002,
            'voi' => 1003,
            'gif' => 1007,
        ];

        $this->msgContent = [
            'txt' => '',
            'pic' => '{"height":1280,"pid":"qa_f5506e905f7738991c2c692ded174e0a","width":720}',
            'voi' => '{"voiceId":"2592","voiceLen":2536,"voiceSize":1714}',
            'gif' =>'{"pid":"https:\\/\\/img.zuoyebang.cc\\/zyb_1441ff319d650866718ecf51ef41cee9.gif","width":200,"height":200}',
        ];

        //conf和data的映射关系
        $this->msgTypeMap =[
            'TXT_SWITCH' => 'txt',
            'PIC_SWITCH' =>'pic',
            'VOI_SWITCH'=>'voi',
            'GIF_SWITCH'=>'gif',
        ];
        
		$this->ChooseTypeMap =[
			'1' => 'txt',
			'2' => 'pic',
			'3' => 'voi',
			'4' => 'gif',
		];


        //文本消息个性化：长文本、脏话集、普通文本、特殊文本
        $this->msgTxtContentStyle = [
            'longTxt' => array(
                'switch' => 1,
                'content' => 'HTTPS在传输数据之前需要客户端（浏览器）与服务端（网站）之间进行一次握手，在握手过程中将确立双方加密传输数据的密码信息。TLS/SSL协议不仅仅是一套加密传输的协议，更是一件经过艺术家精心设计的艺术品，TLS/SSL中使用了非对称加密，对称加密以及HASH算法。握手过程的简单描述如下：1.浏览器将自己支持的一套加密规则发送给网站。2.网站从中选出一组加密算法与HASH算法，并将自己的身份信息',
            ),
            'dirtyTxt' => array(
                'switch' => 1,
                'content' => array('我操', '傻逼', '尼玛', '你妈逼', '妈卖批', 'jj', '干你娘', '日你老母', '扑街', 'CNMB', 'CNM', 'jb', '叼你黑', '干你妈', '猪头', '色狼', '狗逼', 'fack', 'idiot', 'sucks', 'bitch', 'dick', 'prostitute', 'pussy',),
            ),
            'commonTxt' => array(
                'switch' => 1,
                'content' => '',
            ),
            'special' => array(
                'switch' => 1,
                'content' => '!@#$%^&*()_+~{}|:">?看i哦機器我妳那麽妳自行車昜萪惟渏-----測試開發',
            ),
        ];

        //图片消息个性化：
        $this->msgPicContentStyle = [
            'longPic' => array(
                'switch' => 1,
                'content' => '',
            ),
            'widePic' => array(
                'switch' => 1,
                'content' => '',
            ),
            'noPic' => array(
                'switch' => 1,
                'content' => '',
            )
        ];

        //语音消息个性化：
        //$this->msgVoiContentStyle TODO

        $this->msgLogs = [
            'fromUid' => 0,
            'toGroupId'=> 0,
            'msgId' => 0,
            'msgType'=> 0,
            'msgContent'=> '',
            'msgTime'=> '',
            'atUids' => 0,
        ];
    }
}
