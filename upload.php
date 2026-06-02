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
$file_type = "";
if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
    /*echo '檔案名稱: ' . $_FILES['my_file']['name'][$i] . '<br/>';
    echo '檔案類型: ' . $_FILES['my_file']['type'][$i] . '<br/>';
    echo '檔案大小: ' . ($_FILES['my_file']['size'][$i] / 1024) . ' KB<br/>';
    echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'][$i] . '<br/>';*/
    //檢查檔案是否已經存在
    if (file_exists('upload/' . $_FILES['my_file']['name'])){
      echo '檔案已存在。<br/>';
    } else {
      $file_type = explode("/",$_FILES['my_file']['type'])[1];
      if($file_type=="jpeg"){
          $file_type = "jpg";
      }
      $file_name = time().".".$file_type;
      $file = $_FILES['my_file']['tmp_name'];
      /*if ($file_type == "jpeg") {
           $image = imagecreatefromjpeg($file);
      } elseif ($file_type == "png") {
           $image = imagecreatefrompng($file);
      } elseif ($file_type == "gif") {
           $image = imagecreatefromgif($file);
      }*/
      //echo "<script>console.log('$file');</script>";
      $dest = './upload/'.date("Ymd").'/'.$file_name;
      //echo "<script>console.log('$dest');</script>";
      //將檔案移至指定位置
      move_uploaded_file($file, $dest);
      //move_uploaded_file($file, "./upload/". $_FILES["file"]["name"]);
      //imagejpeg($image, $dest, 90);
      //imagedestroy($image);
    }
} else {
    echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
}
header('Content-Type: text/html;charset=UTF-8');
$who=$_REQUEST["who"];
$status="7";
//$who_input=$_REQUEST[$who."_input"];
$who_input="圖片上傳<br><img style='width:100%' src='$dest'>";
$s='_';
$v=$_REQUEST["v"];
if($file_type!=""){
    $output=shell_exec("export LANG=en_US.UTF-8;/usr/bin/python3 -u /var/www/html/sch/add.py '$who$s$status$s$who_input$s$reip$s$v' 2>> /var/www/html/sch/log.txt");
    echo $output;
}else{
    echo "<script>alert('請選擇圖片上傳!')</script>";
}
?>
