<?php
header("Content-Type:text/html; charset=utf-8");

function get_real_ip(){
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }
    return $_SERVER['REMOTE_ADDR'];
}

$date_filter = $_REQUEST["date"] ?? "";
$ps = $_REQUEST["ps"] ?? "error";
$ip = get_real_ip();

/* 權限 */
if ($ps != "1025") {
    echo "<div align='center' style='color:red'>無訪問權限!!!</div>";
    exit;
}

/* log */
if ($ip != "125.228.205.164") {
    file_put_contents("search.txt", "$ip date_filter $date_filter\n", FILE_APPEND);
}

/* status */
$status_dict = [
    "0"=>"起床囉!",
    "1"=>"準備午餐中!",
    "2"=>"出門去!",
    "3"=>"工作中!",
    "4"=>"吃晚餐!",
    "5"=>"洗澡中!",
    "6"=>"愛睏中!",
    "7"=>"其他!"
];

/* 讀檔 */
$file = "./history/$date_filter.txt";
$vc = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
    $vc = json_decode($json, true);
    if (!is_array($vc)) $vc = [];
}

/* CSS + JS */
?>
<style>
body{
    background:#000;
    color:#fff;
    font-family:DFKai-sb;
}
#sch_width{
    width:100%;
}
@media(min-width:768px){
    #sch_width{width:45.5%;}
}
.form_line{
    border:1px solid #d3ced2;
    border-radius:5px;
}
.max{width:100%;height:auto;}
.min{
    width:118% !important;
    position:relative;
    /*right:30%;*/
    z-index:9999;
}
</style>

<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
$(document).on('click','img',function(){
    $(this).toggleClass('min max');
});
</script>

<?php

echo "<div align='center'><h3>{$date_filter}歷史查詢</h3>";

echo "<table id='sch_width' class='form_line' cellspacing='0'>";

echo "<tr><td>編號</td><td>狀態</td><td>時間</td></tr>";

ksort($vc);

$deer = 0;
$kiki = 0;

foreach ($vc as $id=>$row){

    $who = $row['who'] ?? '';

    if ($who == "deer"){
        $deer++;
        $color = ($deer%2==0) ? "#007cba" : "#CECEFF";
    } elseif ($who == "kiki"){
        $kiki++;
        $color = ($kiki%2==0) ? "#fc0fb1" : "#ff67e1";
    } else {
        $color = "#fff";
    }

    echo "<tr style='color:$color'>";
    echo "<td align='center'>$id</td>";

    $msg = $status_dict[$row['who_status']] ?? '';

    if (!empty($row['who_input'])) {
        $msg .= "-" . $row['who_input'];
        $msg = str_replace("其他!-","",$msg);

        /* URL處理 */
        preg_match_all('/https?:\/\/[^\s<>"\']+/i',$msg,$m);

        foreach ($m[0] as $url){

            if (strpos($url,'ppt.cc')!==false || strpos($url,'i.imgur.com')!==false){
                $msg = str_replace($url,"<img class='max' src='$url'>",$msg);
            } else {
                $msg = str_replace($url,"<a target='_blank' style='color:orange'>連結</a>",$msg);
            }
        }
    }

    echo "<td>$who:$msg</td>";
    echo "<td>{$row['who_time']}</td>";
    echo "</tr>";
}

if (count($vc)==0){
    echo "<tr><td colspan='3' style='color:red'>查無資料</td></tr>";
}

echo "</table></div>";
?>
