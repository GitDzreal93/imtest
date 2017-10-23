<?php
/*
*@file  getUidByPhone.php
*@author chenzheng(@zuoyebang.com)
- 功能：根据指定号码段，批量返回UID
- 使用方法：
  - 获取18500000000 至 18500000009的UID
      - php getUidByPhone.php 18500000000 18500000009

*/
##--help
if($argv[1]=="--help")
{
echo"

*@file  getUidByPhone.php
*@author chenzheng(@zuoyebang.com)
- 功能：根据指定号码段，批量返回UID
- 使用方法：
  - 获取18500000000 至 18500000009的UID
      - php getUidByPhone.php 18500000000 18500000009
";
exit;

}

Bd_Init::init();

$phoneStart = 13500000000;
$phoneStop = 13500000000;
if($argc == 2){
    $phoneStart = intval($argv[1]);
    $phoneStop = $phoneStart;
}else if($argc == 3){
    $phoneStart = intval($argv[1]);
    $phoneStop = intval($argv[2]);
	$dataname = "default_userinfo";
}
else if($argc == 4){
	$phoneStart = intval($argv[1]);
	$phoneStop = intval($argv[2]);
	$dataname = $argv[3];
}

else{
    echo 'bad param\n';
    exit(1);
}

$phone_uidtxt = fopen('./data/' . $dataname . '.txt', "w") or die("Unable to open file!");

$objUcloud = new Hk_Service_Ucloud();
for($i = $phoneStart; $i <= $phoneStop; $i++) {
	$uid = $objUcloud->getUserUid($i);
	$phone_uids = $i . " : " . strval($uid) . "\n";
	fwrite($phone_uidtxt, $phone_uids);
}

fclose($phone_uidtxt);

