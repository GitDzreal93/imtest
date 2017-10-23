#!/bin/bash

#连号群群发脚本
declare -i groupStart=128;
declare -i groupEnd=130;

for((i=$groupStart;i<=$groupEnd;i++))
do
	php /home/homework/user/huangdazhen/script/im/IMTest/SendMsg/Controller/IMTest_Run.php & 
	
	if [ $? -eq 0 ] 
	then 
		echo $i 
	fi

done
