
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查詢結果</title>
<style>

.fontst{
   font-family:DFKai-sb,Times New Roman;
   font-size:16px;
}

</style>
</head>
<!--<body onload="parent.formreset()">-->
<body>

<?php
function get_ip(){
if (!empty($_SERVER["HTTP_CLIENT_IP"])){
$ip = $_SERVER["HTTP_CLIENT_IP"];
}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}else{
$ip = $_SERVER["REMOTE_ADDR"];
}
return $ip;
}

function get_real_ip(){
    $ip=false;
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ 
        $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
        for ($i=0; $i < count($ips); $i++){
            if(!preg_match('/^(10172\.16192\.168)\./i', $ips[$i])){
                $ip=$ips[$i];
                break;
            }
        }
    }
    return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
$reip=get_real_ip();
header('Content-Type: text/html;charset=UTF-8');
$who=$_REQUEST["who"];
$status=$_REQUEST[$who."_status"];
//$who_input=$_REQUEST[$who."_input"];
$who_input=$_GET[$who."_input"];
$v=$_REQUEST["v"];
$s='_';
//$output=shell_exec("export LANG=en_US.UTF-8;/usr/bin/python3 -u /var/www/html/sch/add.py '$who$s$status$s$who_input$s$reip$s$v' 2>> /var/www/html/sch/log.txt");
//echo $output;
$status_dict = [
    "0" => "起床囉!",
    "1" => "準備午餐中!",
    "2" => "出門去!",
    "3" => "工作中!",
    "4" => "吃晚餐!",
    "5" => "洗澡中!",
    "6" => "愛睏中!",
    "7" => "其他!",
];


// 時間
$now_time = date("Y-m-d H:i:s");

// 讀 lst.txt 並加資料
$file_path = 'lst.txt';
$vc = [];
if (file_exists($file_path)) {
    $vc = json_decode(file_get_contents($file_path), true) ?? [];
}
$index = count($vc) > 0 ? max(array_keys($vc)) + 1 : 1;

$vc[$index] = [
    "who_status" => $status,
    "who_input"  => $who_input,
    "who_ip"     => $reip,
    "who_time"   => $now_time,
    "who"        => $who
];

file_put_contents($file_path, json_encode($vc, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

// 輸出 JS 給前端
echo "<script>parent.document.querySelector('#{$who}_send_input').value='';</script>";

if ($v != "2") {
    if ($who == "kiki") {
        echo "<script>parent.document.querySelector('#myframe2').src='https://author.lugeshop.com/sch/search.php';</script>";
    } else {
        echo "<script>parent.document.querySelector('#myframe2').src='https://author.lugeshop.com/sch/search_no_alert.php';</script>";
    }
} else {
    echo "<script>parent.renew();</script>";
}

echo "<script>parent.document.querySelector('#myframe').src='';</script>";
// 調整輸入內容
if ($status !== "7") {
    $who_input = $status_dict[$status];
}
// 訊息處理
$data_value = "{$who}說:{$who_input}";

// 寫入 kiki.txt 並發送通知
if ($who == "kiki") {
    file_put_contents("kiki.txt", "$now_time,$who_input\n", FILE_APPEND);
    file_get_contents("https://author.lugeshop.com/discord.php?message=" . urlencode($data_value) . "&channel=note");
    file_get_contents("https://author.lugeshop.com/linev2.php?message=" . urlencode($data_value));
}
?>
