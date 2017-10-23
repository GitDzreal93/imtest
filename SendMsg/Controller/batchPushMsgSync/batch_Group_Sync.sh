#!/bin/bash

#消息发送机器人的uid，phone：13310200000
declare -i uid=2003672384;
declare -i max=99;
declare -i groupStart=128;
declare -i groupEnd=130;

for((i=$groupStart;i<=$groupEnd;i++))
do
	php /home/homework/user/huangdazhen/script/im/batchPushMsgSync/pushMsg/pushMsg.php $max $uid $i & 
	
	if [ $? -eq 0 ] 
	then 
		echo $i 
	fi

done
