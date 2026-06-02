<html>
<head>
<title>老大&細漢日記簿</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link rel="icon" href="https://www.lugeshop.com/image/love.svg">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
body,#kiki_status {
	background-color: #000 !important;
	color: #FFF !important;
        font-size: 16px;
        font-family:DFKai-sb,Times New Roman;
}

.center{
	padding : 5px;
	font-size: 18px;
	font-family:DFKai-sb,Times New Roman;
}
a {display: inline-block; text-decoration: none; color: #00bfff;font-family:DFKai-sb;font-size:18px;font-weight:bold;}


#sch_width,#sch_width2{
    width:100%
}
@media screen and (min-width: 768px){
    #sch_width,#sch_width2{
        width:45%
    }
}
.form_line{
    border-left:1px #d3ced2 solid;
    border-right:1px #d3ced2 solid;
    border-bottom:1px #d3ced2 solid;
    border-top:1px #d3ced2 solid;
    border-collapse:separate;
    border-radius:5px;
}
.btn1 {
      font-family:DFKai-sb,Times New Roman;
      color: black;
      background: transparent;
      background-color: white;
      border: 2px solid #008CBA;
      border-radius: 10px;     
      text-align: center;
      display: inline-block;
      font-size: 16px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      text-decoration: none;
      text-transform: uppercase;
}
.btn1:hover {
      background-color:  #008CBA;
      color: white;
}
.btn2 {
      font-family:DFKai-sb,Times New Roman;
      color: black;
      background: transparent;
      background-color: white;
      border: 2px solid  #ff6781;
      border-radius: 10px;
      text-align: center;
      display: inline-block;
      font-size: 14px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      text-decoration: none;
      text-transform: uppercase;
}
.btn2:hover {
      background-color:  #ff6781;
      color: white;
}
#fb,#ig,#ps{
    color:#28FF28;
}
#websock_s{
    width:20px;
    vertical-align: middle;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.core.min.js"></script>
<script>
password_c = 0;
try{
valid = location.href.split('?');
if(valid[1]=="1025"){
    password_c = 1;
}
}catch(e){

}
if(password_c == 0){
    var password = prompt("請輸入密碼","")
    if (password=="1025"){
    }else{
        if (password=="null"){
            alert('請再輸入一次密碼');
            location.href='https://author.lugeshop.com/sch/';
        }else if (password!="1025"){
            alert('請再輸入一次密碼');
            location.href='https://author.lugeshop.com/sch/';
        }
    }
}
function hidden_status(ele){
    select_value = document.querySelector("#"+ele+"_status").value;
    if(select_value=="2"||select_value=="7"){
        document.querySelector("#"+ele+"_input").style.display="";
    }else{
        document.querySelector("#"+ele+"_input").style.display="none";
    }
}
function send_now(ele){
    who = ele;
    who_status = document.querySelector("#"+ele+"_status").value;
    who_input = document.querySelector("#"+ele+"_send_input").value.replace(/\n/g,"<br>");
    document.querySelector("#myframe").src="https://author.lugeshop.com/sch/add.php?who="+who+"&"+who+"_status="+who_status+"&"+who+"_input="+encodeURIComponent(who_input)+"&v=2";
    //document.querySelector("#myframe").src= "";
}
function date_filter(){
    dd = document.querySelector("#end_date").value;
    window.open("https://author.lugeshop.com/sch/filter.php?date="+ dd +"&ps=1025");
}
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight+8 + 'px';
}
function copy(id){
    var str = document.getElementById(id);
    window.getSelection().selectAllChildren(str);
    document.execCommand('Copy');
}
function music_play(){
    var sound = new Howl({
        src: [ "https://author.lugeshop.com/sch/alert.mp3?v=1101211" ],
        autoplay: false,
        loop: false,
    });
    sound.play();
}
function sos_alert(){
    document.querySelector("#myframe").src="https://author.lugeshop.com/sch/sos.php";
    alert("已呼叫鹿哥囉!");
}
</script>
</head>
<body>
<div id="today_form" align="center" style="color:blue;font-size:24px"></div>
	<div align="center">	　 　　　 　
		<table id="sch_width" class="form_line">
			<tr>
                                
				<td align="center" style="width:20%">姓名</td>
                                <td>當前狀態<div style="display:none" id="message_len">0</div>
                                <button style="display:none" id="music_go" onclick="music_play();">點我</button>
                                </td>
			</tr>
			<!--<tr>
				<td align="center">小鹿</td>
                                <td>
                                <div style="float:left;padding:1%;">
                                <select id="deer_status" name="deer_status" style="font-size:16px;line-height:16px;" onchange="hidden_status('deer')">
                                    <option value="0">起床囉!</option>
                                    <option value="1">準備午餐中!</option>
                                    <option value="2">出門去!</option>
                                    <option value="3">工作中!</option>
                                    <option value="4">吃晚餐!</option>
                                    <option value="5">洗澡中!</option>
                                    <option value="6">愛睏中!</option>
                                    <option value="7">其他!</option>
                               </select>
                               </div>
                               <div id="deer_input" style="float:left;width:40%;padding:1%;display:none"><input id="deer_send_input" name="deer_input" style="width:100%;font-size:16px;"></div>
                               <div style="float:left;padding:1%;"><button class="btn1" onclick="send_now('deer');">送出</button></div>
                               </td>
			</tr>-->
			<tr>
				<td valign="top" align="center">小琦<img id="websock_s" src="https://author.lugeshop.com/sch/load.png"></td>
                                <td>
                                <div style="float:left;padding:1%;">
                                <select id="kiki_status" name="kiki_status" style="width:110px;font-size:16px;line-height:16px;" onchange="hidden_status('kiki')">
                                    <option value="0">起床囉!</option>
                                    <option value="1">準備午餐中!</option>
                                    <option value="2">出門去!</option>
                                    <option value="3">工作中!</option>
                                    <option value="4">吃晚餐!</option>
                                    <option value="5">洗澡中!</option>
                                    <option value="6">愛睏中!</option>
                                    <option value="7">其他!</option>
                               </select>
                               </div>
                               <div id="kiki_input" style="float:left;width:40%;padding:1%;display:none"><textarea id="kiki_send_input" name="kiki_input" style="width:100%;font-size:16px;height:50px;max-width: 190px;"></textarea></div>
                               <div style="float:left;padding:1%;"><button class="btn2" onclick="send_now('kiki');">送出</button></div>
                               </td> 
                      </tr>
                      <tr>
                        <td align="center">圖片上傳</td>
                        <td  style="padding:1%">
                           <form action="./upload.php?who=kiki&v=2" style="margin: auto;" method="post" enctype="multipart/form-data" id="photo_upload" target="myframe">
                              <input style="width:120px;" type="file" name="my_file" accept="image/gif, image/jpeg, image/png">
                              <button onclick="document.querySelector('#photo_upload').submit();" class="btn2">上傳</button>
                           </form>
                        </td>
                        </tr>
                      <tr>
                          <td align="center">歷史查詢</td>
                          <td><div style="float:left;padding:1%;"><input name="end_date" id="end_date" type="date" style="width:140px" min="2022-02-22"></div>
                          <div style="float:left;padding:1%;">
                          <button class="btn2" onclick="date_filter()" >查詢</button>
                          <button class="btn2" onclick="sos_alert()" >烙人</button>
                         </div></td>
                      </tr>
		</table>
	</div>
</body>
<div align="center" style="color:orange;font-size:24px">紀錄表 <a onclick="renew();"><font color="yellow" size="6">⟳</font></a></div>
<iframe id="myframe" name="myframe" height="100%" width="100%" frameborder="0" style="display:none;" scrolling="no"></iframe>
<div id="table_show">
<?php
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
            //if(!preg_match('/^(10172\.16192\.168)\./i', $ips[$i])){
                $ip=$ips[$i];
                break;
            }
        }
    }
    return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
ob_start();
$_GET['index'] = $_SERVER['HTTP_REFERER'] ?? 'first';
include '/var/www/html/sch/search.php';
$result = ob_get_clean();
echo $result;
?>
</div>
</html>
<script>
var Today=new Date();
today_show = Today.getFullYear()+ " 年 " + (Today.getMonth()+1) + " 月 " + Today.getDate() + " 日的操作表";
document.querySelector("#today_form").appendChild(document.createTextNode(today_show));
//document.querySelector("#myframe2").width=document.body.offsetWidth;
var dd = new Date();
dd.setDate(dd.getDate()-1);
var y = dd.getFullYear();
var m = dd.getMonth()+1;//獲取當前月份的日期
var d = dd.getDate();
if(m<10){m="0"+m;}
if(d<10){d="0"+d;}
document.querySelector("#end_date").max=y+"-"+m+"-"+d;
document.querySelector("#end_date").value=y+"-"+m+"-"+d;
function renew() {
    jQuery("#deer_form").load(location.href + " #deer_form:first>*", function() {
        // 在内容重新加载后手动重新绑定点击事件
        bindClickEventToImages();

        var rowCount = $("#sch_width2 tr").length-1;
        var rowCountFirst = $("#sch_width2 tr:eq(1) td:eq(1)").text();
        var len = parseInt(document.querySelector("#message_len").textContent);
        //console.log(rowCountFirst);
        if($("#sch_width2 tr:eq(1) td").text().trim()=="查無資料"){
            rowCount = 0;
        }
        if (rowCountFirst!="" && rowCount > len) {
            document.querySelector("#music_go").click();
            document.querySelector("#message_len").innerText = rowCount;
        }
        if(len != rowCount){
            document.querySelector("#message_len").innerText = rowCount;
        }
    });
}
function bindClickEventToImages() {
    // 重新绑定点击事件到图片
    $('img').off('click').on('click', function() {
        $(this).toggleClass('min');
        $(this).toggleClass('max');
    });
}

$(document).ready(function() {
    // 初始页面加载时绑定点击事件到图片
    bindClickEventToImages();

    // 第一次进入时执行 renew 函数
    renew();
});
const socketUrl = [
    "wss://test3.lugeshop.com/ws/",
    "wss://author.lugeshop.com/ws/"
];
let currentMessage = "";  // 儲存目前的訊息
let reconnectInterval = 1000; // 初始重新連接間隔（毫秒）
const maxReconnectInterval = 10000; // 最大重新連接間隔（毫秒）
let reconnectTimeout = null; // 重新連接的計時器
let socket = null;
let reconnectAttempts = 0; // 重新連線次數
let currentUrlIndex = 0;
const maxReconnectAttempts = 2; // 最大重新連線次數
window.addEventListener('beforeunload', function() {
    if (socket) {
        socket.close();
    }
});
function connectWebSocket() {
    socket = new WebSocket(socketUrl[currentUrlIndex]);

    socket.onopen = function(event) {
        console.log("WebSocket 連接已建立。");
        document.querySelector("#websock_s").src="https://author.lugeshop.com/sch/ok.png";
        clearInterval(reconnectTimeout); // 清除重新連接計時器
        reconnectInterval = 1000; // 重新連接成功後，重設重新連接間隔
        reconnectAttempts = 0; // 重設重新連線次數
        currentUrlIndex = 0;
    };

    socket.onmessage = function(event) {
        const oriMessage = parseInt(document.querySelector("#message_len").textContent);
        const newMessage = parseInt(event.data);
        //console.log(oriMessage);
        //console.log(newMessage);
        if (newMessage !== oriMessage) {
            //currentMessage = newMessage;
            console.log("renew...");
            renew();
        }
    };

    socket.onclose = function(event) {
        console.log("WebSocket連線已關閉。正在重新連線...");
        document.querySelector("#websock_s").src="https://author.lugeshop.com/sch/load.png";
        if (reconnectAttempts < maxReconnectAttempts) {
            reconnectAttempts++;
            reconnectInterval = Math.min(reconnectInterval * 2, maxReconnectInterval);
            reconnectTimeout = setTimeout(connectWebSocket, reconnectInterval);
        } else {
            console.log("已達到最大重新連線次數。");
            document.querySelector("#websock_s").src="https://author.lugeshop.com/sch/error.png";
            fallbackReconnect();
        }
    };

    socket.onerror = function(event) {
        console.log("WebSocket連線出現錯誤: ", event);
        document.querySelector("#websock_s").src="https://author.lugeshop.com/sch/error.png";
        // 可進行其他錯誤處理
    };
}
function fallbackReconnect() {
    // 換下一個 URL
    currentUrlIndex++;

    if (currentUrlIndex >= socketUrl.length) {
        currentUrlIndex = 0; // 全部試過 → 重來
        console.log("全部節點失敗，1秒後重試");
    }

    setTimeout(connectWebSocket, 1000);
}
// 初始連接 WebSocket
connectWebSocket();
</script>
