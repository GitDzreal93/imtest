<?php

/**
 * Created by PhpStorm.
 * User: Dzreal_93
 * Date: 2017/10/15
 * Time: 11:37
 */
class IMTest_Conf
{
    public static function getIMConf($PATH)
    {
        $confArr = file($PATH);
        $arrOutput = array();
        foreach ($confArr as $str) {
            if (substr($str, 0, 1) == "#" || substr($str, 0, 1) == "") {
                continue;
            } else {
                $str = trim($str);
                $arrData[] = $str;
                $arrData = array_diff($arrData, [""]);
                foreach ($arrData as $item) {
                    list($key, $value) = explode("=", $item);
                    $arrOutput[$key] = $value;
                }
            }
        }
        return $arrOutput;
    }
}
/*
$PATH = '/home/homework/user/huangdazhen/script/im/IMTest/SendMsg/Conf/Config.txt';
$conf =IMTest_Conf::getIMConf($PATH);
var_export($conf);
*/
