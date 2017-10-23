<?php

/**
 * Created by PhpStorm.
 * User: Dzreal_93
 * Date: 2017/10/18
 * Time: 10:20
 */

class IMTest_Log
{
    public function imLog($logPath,$arrLog){
		$logFile = $logPath . date('Ymd',time()) . '.log';
        $items = array();
        foreach ($arrLog as $key => $value){
            $item = "[" . $key ."]:" . $value;
            $items[] = $item;
        }
        $itemTime = date("Y-m-d H:i:s",time());
        $itemId = date("Ymd");
        $itemContent = implode(" ",$items);
        $itemStr = $itemTime . "\t" . $itemId . "\t" . $itemContent . "\n";
        file_put_contents($logFile,$itemStr, FILE_APPEND);
    }
}
