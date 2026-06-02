<?php
header("Content-Type:text/html; charset=utf-8");

$status_dict = [
    "0" => "起床囉!",
    "1" => "準備午餐中!",
    "2" => "出門去!",
    "3" => "工作中!",
    "4" => "吃晚餐!",
    "5" => "洗澡中!",
    "6" => "愛睏中!",
    "7" => "其他!"
];

$in_index = $_GET['index'] ?? '';

$file = "lst.txt";

if (!file_exists($file)) {
    file_put_contents($file, "{}");
}
$json = file_get_contents($file);
$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
$vc = json_decode($json, true);
if (!is_array($vc)) {
    $vc = [];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
    font-family:DFKai-sb,Times New Roman;
}

.font_color{
    color:white;
}

#sch_width,#sch_width2{
    width:100%;
}

@media screen and (min-width:768px){
    #sch_width,#sch_width2{
        width:45.5%;
    }
}

.form_line{
    border:1px #d3ced2 solid;
    border-radius:5px;
}

.btn3{
    font-family:DFKai-sb,Times New Roman;
    background:white;
    border:2px solid red;
    border-radius:10px;
    color:black;
    cursor:pointer;
    padding:5px 10px;
}

.btn3:hover{
    background:red;
    color:white;
}

.max{
    width:100%;
    height:auto;
}
.min {width:250% !important;height:auto;z-index:9999;position: relative;right: 30%;}
</style>

<script>
function delete_now(ele,id){
    if(confirm("是否刪除")){
        document.querySelector("#myframe").src=
        "delete.php?who="+ele+
        "&status_id="+id+
        "&v=2";
    }
}
</script>

</head>
<body>

<div id="deer_form" align="center">

<table id="sch_width2"
       class="form_line font_color"
       cellspacing="0"
       cellpadding="5">

<tr>
<td width="15%" align="center">編號</td>
<td width="40%">狀態</td>
<td>操作時間</td>
<td align="center" width="10%">刪除</td>
</tr>

<?php

krsort($vc,SORT_NUMERIC);

$deer_index = 0;
$kiki_index = 0;

foreach($vc as $item=>$row){

    $who = $row['who'] ?? '';

    if($who=='deer'){

        $deer_index++;

        $color = ($deer_index % 2)
            ? "#CECEFF"
            : "#007cba";

    }elseif($who=='kiki'){

        $kiki_index++;

        $color = ($kiki_index % 2)
            ? "#ff67e1"
            : "#fc0fb1";

    }else{

        $color = "#FFFFFF";
    }

    echo "<tr style='color:$color'>";

    echo "<td align='center'>{$item}</td>";

    $msg = '';

    if(empty($row['who_input'])){

        $msg = $status_dict[$row['who_status']] ?? '';

    }else{

        $msg =
            ($status_dict[$row['who_status']] ?? '') .
            "-" .
            $row['who_input'];

        $msg = str_replace("其他!-","",$msg);

        $url_index = 0;

        preg_match_all(
            '/(?<![=])https?:\/\/[^\s<>"\']+/i',
            $msg,
            $matches
        );

        foreach($matches[0] as $url){

            if(
                strpos($url,'ppt.cc')!==false ||
                strpos($url,'i.imgur.com')!==false
            ){

                $msg = str_replace(
                    $url,
                    "<img style='width:200px' src='{$url}'>",
                    $msg
                );

            }else{

                $url_index++;

                $msg = str_replace(
                    $url,
                    "<a style='color:orange'
                        target='_blank'
                        href='{$url}'>
                        連結{$url_index}
                    </a>",
                    $msg
                );
            }
        }
    }

    echo "<td>{$who}:{$msg}</td>";

    echo "<td>" .
        htmlspecialchars($row['who_time'] ?? '') .
        "</td>";

    echo "<td align='center'>
        <button
        class='btn3'
        onclick=\"delete_now('lst','{$item}')\">
        刪除
        </button>
    </td>";

    echo "</tr>";
}

if(count($vc)==0){

    echo "
    <tr>
        <td colspan='4'
            align='center'
            style='color:red'>
            查無資料
        </td>
    </tr>";
}

?>

</table>

</div>

<?php
//echo "<script>console.log('123')</script>";
if($in_index=="first"){
    echo "<script>console.log('$in_index')</script>";
    $cmd = "ssh linchingyen@125.228.205.164 'python E:/sch/run.py' > /dev/null 2>&1 &";
    $result = shell_exec($cmd . " 2>&1");
    echo $result;
    ?>
    <script>
    if(document.querySelector("#message_len")){
        document.querySelector("#message_len").innerText =
            <?= $deer_index + $kiki_index ?>;
    }
    </script>
    <?php
}
?>

</body>
</html>
