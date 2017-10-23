#!/bin/bash

#一个群内多人同时发消息
declare -i groupId=128;
declare -i max=20;
declare -a arrayMem;
arrayMem=($(awk '{print $3}' ./data/default_userinfo.txt))

#echo ${arrayMem[@]}

for i in ${arrayMem[@]}
do
	php /home/homework/user/huangdazhen/script/im/batchPushMsgSync/pushMsg/pushMsg.php $max $i $groupId & 	
	if [ $? -eq 0 ] 
	then 
		echo $i 
	fi

done
