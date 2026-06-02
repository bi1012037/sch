<title>IP查詢</title>
<link rel="icon" href="https://www.lugeshop.com/image/love.svg">
<script>
password_c = 0;
try{
valid = location.href.split('?');
if(valid[1]=="6688"){
    password_c = 1;
}
}catch(e){

}
if(password_c == 0){
    var password = prompt("請輸入密碼","")
    if (password=="6688"){
    }else{
        if (password=="null"){
            alert('請再輸入一次密碼');
            location.href='https://author.lugeshop.com/sch/ip.php';
        }else if (password!="6688"){
            alert('請再輸入一次密碼');
            location.href='https://author.lugeshop.com/sch/ip.php';
        }
    }
}
</script>
<?php
$file_path = "search.txt";
if(file_exists($file_path)){
$str = file_get_contents($file_path);//將整個檔案內容讀入到一個字串中
$str = str_replace("\n","<br>",$str);
echo $str;
}
?>
