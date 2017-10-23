<?php
/**
 * Created by PhpStorm.
 * User: Dzreal
 * Date: 2017/10/17
 * Time: 16:35
 */
/*
                         _ooOoo_
                        o8888888o
                        88" . "88
                        (| -_- |)
                        O\  =  /O
                     ____/`---'\____
                   .'  \\|     |//  `.
                  /  \\|||  :  |||//  \
                 /  _||||| -:- |||||-  \
                 |   | \\\  -  /// |   |
                 | \_|  ''\---/''  |   |
                 \  .-\__  `-`  ___/-. /
               ___`. .'  /--.--\  `. . __
            ."" '<  `.___\_<|>_/___.'  >'"".
           | | :  `- \`.;`\ _ /`;.`/ - ` : | |
           \  \ `-.   \_ __\ /__ _/   .-` /  /
      ======`-.____`-.___\_____/___.-`____.-'======
                         `=---='
      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
               佛祖保佑       永无BUG
      */
require_once('imtest/SendMsg/Logic/IMTest_SendLogic.php');
$objRun = new IMTest_SendLogic();

echo "程序正常启动中... \n 日志地址：/home/homework/user/huangdazhen/script/im/IMTest/TestLog/log/Msg_log \n 配置地址：/home/homework/user/huangdazhen/script/im/IMTest/SendMsg/Conf/Config.txt \n";

$objRun->execute();

