<?php

/**
 * Created by PhpStorm.
 * User: Dzreal_93
 * Date: 2017/10/16
 * Time: 23:36
 */
require_once('imtest/SendMsg/Conf/IMTest_Conf.php');
require_once('imtest/SendMsg/Data/IMTest_Msg_Data.php');
require_once ('imtest/SendMsg/Interfaces/IMTest_Talk2Send.php');

class IMTest_SendLogic
{
    public function __construct()
    {
        $this->objTalk2Send = new IMTest_Talk2Send();
        $this->objMsgData = new IMTest_Msg_Data();
    }

    public function execute()
    {
//        这个数组只是拿来做参考用的，调用PHP：IM/PS层的方法需要传如下模板
//        $arrInput = array(
//            'uid' => 0,
//            'toUid' => 0,
//            'toGroupId' => 0,
//            'msgType' => 0,
//            'msgContent' => '',
//            'atUids' => '',
//            'productId' => 0,
//            'cuid' => '',
//        );

        //获取Conf数据
        $arrConfAll = IMTest_Conf::getIMConf('/home/homework/user/huangdazhen/script/im/IMTest/SendMsg/Conf/Config.txt');
        if (empty($arrConfAll)) {
            die('Configure is not found!');
        }
		print_r($arrConfAll);
		$this->logicSend($arrConfAll);

    }

    private function logicSend($dataInput)
    {
        //配置文件分组分类
        //常规消息发送数
        $sendMax = $dataInput['SEND_MSG_COUNT'];
		//var_export($sendMax);
        //通用数据
        $baseInput = array(
            'uid' => isset($dataInput['FROM_UID']) ? intval($dataInput['FROM_UID']) : 0,
            'toUid' => isset($dataInput['TO_UID']) ? intval($dataInput['TO_UID']) : 0,
            'toGroupId' => isset($dataInput['TO_GROUPID']) ? intval($dataInput['TO_GROUPID']) : 0,
            'productId' => isset($dataInput['PRODUCT_ID']) ? intval($dataInput['PRODUCT_ID']) : 0,
            'cuid' => isset($dataInput['USER_CUID']) ? strval($dataInput['USER_CUID']) : '',
        );
		
		//var_export($baseInput);
		
		
        //At消息
        $atInfo = array(
            'isAtMsg' => isset($dataInput['IS_SEND_AT_MSG']) ? intval($dataInput['IS_SEND_AT_MSG']) : 0,
            'atCount' => isset($dataInput['SEND_AT_MSG_COUNT']) ? intval($dataInput['SEND_AT_MSG_COUNT']) : 0,
            'atCommonSwitch' => isset($dataInput['IS_SEND_COMMON_IN_AT']) ? intval($dataInput['IS_SEND_COMMON_IN_AT']) : 0,
            'atCommonCount' => isset($dataInput['SEND_AT_COMMON_MSG_COUNT']) ? intval($dataInput['SEND_AT_COMMON_MSG_COUNT']) : 0,
            'atUid' => isset($dataInput['AT_UID']) ? intval($dataInput['AT_UID']) : 0,
            'atNicname' => isset($dataInput['AT_NICNAME']) ? strval($dataInput['AT_NICNAME']) : 0,
            'atPhone' => isset($dataInput['AT_PHONE']) ? intval($dataInput['AT_PHONE']) : 0,
        );
		//var_export($atInfo . "\n", true);
		
        //消息发送频率
        $frequencyInfo = array(
            'msgFrequencyInfo' => isset($dataInput['MSG_FREQUENCY']) ? intval($dataInput['MSG_FREQUENCY']) : 0,
            'msgAtFrequencyInfo' => isset($dataInput['MSG_AT_FREQUENCY']) ? intval($dataInput['MSG_AT_FREQUENCY']) : 0,
            'sendInterval' => isset($dataInput['MSG_INTERVAL']) ? intval($dataInput['MSG_INTERVAL']) : 0,
            'sendAtInterval' => isset($dataInput['MSG_AT_INTERVAL']) ? intval($dataInput['MSG_AT_INTERVAL']) : 0,
            'sendAtCommonInterval' => 3,//isset($dataInput['MSG_AT_COMMON_INTERVAL']) ? intval($dataInput['MSG_AT_COMMON_INTERVAL']) : 0,
        );
        //var_export($frequencyInfo);
		
        //发送策略
        $strategyInfo = isset($dataInput['MSG_SEND_STRATEGY']) ? intval($dataInput['MSG_SEND_STRATEGY']) : 0;
        $chooseMsgType = isset($dataInput['MSG_SEND_CHOOSE']) ? intval($dataInput['MSG_SEND_CHOOSE']) : 0;
        //var_export($strategyInfo);
		//var_export($chooseMsgType);

        //可发送消息类型开关
        $msgTypeInfo = array(
            'TXT_SWITCH' => isset($dataInput['TXT_SWITCH']) ? intval($dataInput['TXT_SWITCH']) : 0,
            'PIC_SWITCH' => isset($dataInput['PIC_SWITCH']) ? intval($dataInput['PIC_SWITCH']) : 0,
            'VOI_SWITCH' => isset($dataInput['VOI_SWITCH']) ? intval($dataInput['VOI_SWITCH']) : 0,
            'GIF_SWITCH' => isset($dataInput['GIF_SWITCH']) ? intval($dataInput['GIF_SWITCH']) : 0,
        );
		//var_export($msgTypeInfo);
        //个性化配置
        $selfStyleInfo = array(
            'styleSwich' => isset($dataInput['PERSONALIZATION_SWITCH']) ? intval($dataInput['PERSONALIZATION_SWITCH']) : 0,
            'txtStyle' => isset($dataInput['TXT_CONTENT_PERSONALIZATION']) ? intval($dataInput['TXT_CONTENT_PERSONALIZATION']) : 0,
            'picStyle' => isset($dataInput['PIC_CONTENT_PERSONALIZATION']) ? intval($dataInput['PIC_CONTENT_PERSONALIZATION']) : 0,
            'voiStyle' => isset($dataInput['VOI_CONTENT_PERSONALIZATION']) ? intval($dataInput['VOI_CONTENT_PERSONALIZATION']) : 0,
        );
        //var_export($selfStyleInfo);
        $arrPath = array(
            'confPath' => isset($dataInput['CONF_PATH']) ? strval($dataInput['CONF_PATH']) : '',
            'logPath' =>  isset($dataInput['LOG_PATH']) ? strval($dataInput['LOG_PATH']) : '',
            'ctrlPath' =>  isset($dataInput['CTRL_PATH']) ? strval($dataInput['CTRL_PATH']) : '',
        );
        //var_export($arrPath);
        //读取配置中能够发送的消息类型
        $msgTypeList = array();
        $arrType = array();

        foreach ($msgTypeInfo as $key => $value) {
            if ($value !== 0) {
                $msgTypeList[] = $key;
            }
        }
        foreach ($msgTypeList as $typeMapKey) {
            $typeKey = $this->objMsgData->msgTypeMap[$typeMapKey];
            $arrType[$typeKey] = $this->objMsgData->msgType[$typeKey];
        }
        //通用字段数组
        $arrInput = $baseInput;
		//var_export($arrInput);

        //业务逻辑判断部分：at消息走at消息逻辑，否则走普通消息逻辑
        if ($atInfo['isAtMsg'] == 1) {
            $atMax = $atInfo['atCount'];
            $atUid = $atInfo['atUid'];
//            $atPhone = $atInfo['atPhone'];
            $atNicname = $atInfo['atNicname'];
            $arrInput['msgType'] = $this->objMsgData->msgType['txt'];

            for ($at = 1; $at <= $atMax; $at++) {
				$arrInput['atUids'] = $atUid;
                $arrInput['msgContent'] = "@" . $atNicname . " " . "这是第" . strval($at) . "条at";
                $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                //设置每发送一条@消息到下一条消息的间隔
                if ($frequencyInfo['msgAtFrequencyInfo'] == 0) {
                    $atInterval = $frequencyInfo['sendAtInterval'];
                } elseif ($frequencyInfo['msgAtFrequencyInfo'] == 1) {
                    $atInterval = rand(1, 10);
                } else {
                    $atInterval = 1;
                }
                usleep($atInterval*1000000);
                
				//设置是否在@消息里面穿插普通消息,若设置为0，则不穿插普通消息，若为1则穿插普通消息
                if ($atInfo['atCommonSwitch'] == 0) {
                    continue;
                } else {
					unset($arrInput['atUids']);
					//传入穿插普通消息的条数，效果即为，发送1条@，发送n条普通消息，发送下一条@
                    for ($count = 1; $count <= $atInfo['atCommonCount']; $count++) {
						//strategyInfo为0时，针对普通消息，在可发送的消息类型池中，随机选择选择一种消息类型的消息进行发送
                        if ($strategyInfo == 1) {
                            //发随机消息类型
                            $sendType = array_rand($arrType);
                            $arrInput['msgType'] = $arrType[$sendType];
							//当消息类型为文本类型时，自动转为发送 报数 消息
                            if ($sendType == 'txt') {
                                $arrInput['msgContent'] = "报数" . strval($count);
								var_export($arrInput);
                                $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                            } else {
								//其他消息分别取其消息模板
                                $arrInput['msgContent'] = $this->objMsgData->msgContent[$sendType];
								var_export($arrInput);
                                $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                            }
                            usleep($frequencyInfo['sendAtCommonInterval']*1000000);
                        } else {
                            //strategyInfo不为0时，选择一种消息类型进行发送，不受可发送的消息类型池的影响，即发送单消息类型
                    		$msgTypeStr = $this->objMsgData->ChooseTypeMap[$chooseMsgType];
							$arrInput['msgType'] = intval($this->objMsgData->msgType[$msgTypeStr]);
                    		if ($msgTypeStr == 'txt' && $arrInput['msgType'] == 1001) {
								$arrInput['msgContent'] = "报数" . strval($count);
							}else{
                    			$arrInput['msgContent'] = $this->objMsgData->msgContent[$msgTypeStr];
							}
                    		$this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                            usleep($frequencyInfo['sendAtCommonInterval']*1000000);
                        }
                    }
                }
			}
        } else {
			//走普通消息逻辑
            for ($count = 1; $count <= $sendMax; $count++) {
                //设置发送普通消息类型的时间间隔 0：定频发送，1：随机频率发送，其他：1s发送一次
                if ($frequencyInfo['msgFrequencyInfo'] == 0) {
                    $msgInterval = $frequencyInfo['sendInterval'];
                } elseif ($frequencyInfo['msgFrequencyInfo'] == 1) {
                    $msgInterval = rand(1, 10);
                } else {
                    $msgInterval=1;
                }
                
				//strategyInfo = 1 随机发送普通消息类型；strategyInfo = 其他，固定发送普通消息类型
                if ($strategyInfo == 1) {
					//从可发送消息池中，随机选择一种消息类型来发送
                    $sendType = array_rand($arrType);
                    $arrInput['msgType'] = $arrType[$sendType];
                    if ($sendType == 'txt') {
                        $arrInput['msgContent'] = "报数" . strval($count);
                        $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                    } else {
                        $arrInput['msgContent'] = $this->objMsgData->msgContent[$sendType];
                        $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                    }
                    usleep($msgInterval*1000000);
                } else {
                    //发单消息类型
                    $msgTypeStr = $this->objMsgData->ChooseTypeMap[$chooseMsgType];
					$arrInput['msgType'] = intval($this->objMsgData->msgType[$msgTypeStr]);
                    if ($msgTypeStr == 'txt' && $arrInput['msgType'] == 1001) {
						$arrInput['msgContent'] = "报数" . strval($count);
					}else{
                    	$arrInput['msgContent'] = $this->objMsgData->msgContent[$msgTypeStr];
					}
					var_export($arrInput);
                    $this->objTalk2Send->sendMsg($arrPath['logPath'],$arrInput);
                    usleep($msgInterval*1000000);
                }
            }
		}
        echo "程序运行完毕 \n" . "日志存放目录：" . $arrPath[ 'logPath'] . "\n" ."配置文件目录：" . $arrPath[ 'confPath']  ."\n" . "中控程序执行目录：" . $arrPath[ 'ctrlPath']  ."\n" . "欢迎再次使用！\n";
    }

}


//$objSendLogic = new IMTest_SendLogic();
//$objSendLogic->execute();

