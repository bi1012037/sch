
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="https://www.lugeshop.com/image/love.svg">
<script src="https://code.jquery.com/jquery-latest.js"></script>
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
$date_filter=$_REQUEST["date"];
if(isset($_REQUEST["ps"])){
    $ps=$_REQUEST["ps"];
}else{
    $ps="error";
}
$output=shell_exec("export LANG=en_US.UTF-8;/usr/bin/python3 -u /var/www/html/sch/filter.py $date_filter $ps $reip");
echo $output;

?>
