# -*- coding: UTF-8 -*-
import time
import datetime
import os
import re
import base64
import requests
import sys
import codecs
import random
import smtplib
import string
import json
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

if os.path.dirname(__file__) != '':
    os.chdir(os.path.dirname(__file__))

now_time = datetime.datetime.now()
now_time = now_time.strftime("%Y-%m-%d %X")
fundnow = datetime.datetime.now()
fyear = fundnow.year
fmonth = fundnow.month
fday = fundnow.day
ip = sys.argv[1]
mail_check = 0
if(ip!="125.228.205.164"):  #125.228.205.164
    with open("search.txt","r",encoding="utf_8_sig") as v:
        vc = v.read()
    if "%s_search(%s" % (ip,datetime.datetime.now().strftime("%Y-%m-%d %H:")) not in vc:
        mail_check += 1
    os.system("echo '%s_search(%s)' >> search.txt" % (ip,now_time))
status_dict={"0":"起床囉!",
             "1":"準備午餐中!",
             "2":"出門去!",
             "3":"工作中!",
             "4":"吃晚餐!",
             "5":"洗澡中!",
             "6":"愛睏中!",
             "7":"其他!"}


css='''<style>
body{
    font-family:DFKai-sb,Times New Roman;
    overflow: -moz-hidden-unscrollable;
    height: 100%
}
body::-webkit-scrollbar {
    display: none;
}
.font_color{
    color:white;
}
#sch_width{
    width:100%;
}
@media screen and (min-width: 768px){
    #sch_width{
        width:45.5%;
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
.btn3 {
      font-family:DFKai-sb,Times New Roman;
      color: #0099CC;
      background: transparent;
      background-color: white;
      border: 2px solid red;
      border-radius: 10px;
      //border: none;
      color: black;
      text-align: center;
      display: inline-block;
      font-size: 16px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      text-decoration: none;
      text-transform: uppercase;
}
.btn3:hover {
      background-color:  red;
      color: white;
}
.max{width:100%;height:auto;}
.min{width:249% !important;height:auto;z-index:9999;position: relative;right: 37%;}
</style>'''
js_script='''<script>
$(function(){
$('img').click(function(){

$(this).toggleClass('min');
$(this).toggleClass('max');
});
});
function switch_close(elementor){
    elementor.forEach(function(value){
        document.getElementById(value).style.display="none";
    });
}
function switch_open(elementor){
    elementor.forEach(function(value){
        document.getElementById(value).style.display="";
    });
}
function delete_now(ele,ele_id){
    var r=confirm("是否刪除");
    if (r==true){
        document.querySelector("#myframe").src="https://author.lugeshop.com/sch/delete.php?who="+ele+"&status_id="+ele_id;
    }
}
</script>'''
print(css)
print(js_script)
print('<meta name="viewport" content="width=device-width, initial-scale=1">')
name="lst"
try:
    with open("%s.txt" % name,"r",encoding="utf_8_sig") as v:
        #vc = eval(v.read())
        vc_raw = json.load(v)
        vc = {int(k): v for k, v in vc_raw.items()}
        # 將 key 轉回 int，保持原本數字順序邏輯
        #vc = {int(k): v for k, v in vc_raw.items()}
        #vc = eval(v.read())
except:
    os.system('echo {} > %s.txt' % name)
    vc = {}
print('<div id="deer_form" align="center" ><table id="sch_width" class="form_line font_color" cellspacing=0 cellpadding=0>')
print('<tr><td width="15%" align="center">編號</td><td width="40%">狀態</td><td>操作時間</td><td align="center" width="10%">刪除</td></tr>')
test = sorted(vc.keys(),reverse = True)
deer_index = 0
kiki_index = 0
for item in test:
    #index += 1
    who = vc[item]['who']
    if who == "deer":
        deer_index += 1
        if deer_index % 2 ==0:
            print('<tr style="color:#007cba">')
        else:
            print('<tr style="color:#CECEFF">')
    if who == 'kiki':
        kiki_index += 1
        if kiki_index % 2 ==0:
            print('<tr style="color:#fc0fb1">')
        else:
            print('<tr style="color:#ff67e1">')
    print("<td align='center'>%s</td>" % item)
    if vc[item]['who_input']=="":
        print("<td>%s:%s</td>" % (who,status_dict[vc[item]['who_status']]))
    else:
        clean_message = "%s-%s" % (status_dict[vc[item]['who_status']],vc[item]['who_input'])
        clean_message = clean_message.replace("其他!-","")
        url_index = 0
        urls = re.findall(r'({[^\s!,!，]+})', clean_message)
        for i in urls:
             if "http" in i:
                 #url_index += 1
                 url = i.replace("{","").replace("}","")
                 if "ppt.cc" in url or "i.imgur.com" in url:
                     clean_message = clean_message.replace(i,"<img style='width:200px' src='%s'>" % url)
                 else:
                     url_index += 1
                     clean_message = clean_message.replace(i,"<a style='color:orange' target='_blank' href='"+url+"'>連結%d</a>" % url_index)
        print("<td>%s:%s</td>" % (who,clean_message))
    print("<td>%s</td>" % vc[item]['who_time'])
    print("<td align='center'style='padding:5px'><button class='btn3' onclick='delete_now(\"%s\",\"%s\")'>刪除</button></td>" % (name,item))
    print('</tr>')
if len(vc)==0:
    print('<tr><td colspan="3" align="center" style="color:red">查無資料</td></tr>')
print('</table></div>')
#print('<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.core.min.js"></script>')
#print('<audio id="mu" muted><source src = "alert.mp3" type = "audio/mpeg"> </audio>')
#print('<button style="display:none" id="music_go" onclick="music_play();">點我</button>')
print('<iframe id="myframe" name="myframe" height="100%" width="100%" frameborder="0" style="display:none;" scrolling="no"></iframe>')
js_len='''<script>
function music(){
    len = parseInt(parent.document.querySelector("#message_len").textContent);
    if(len != %d){
        parent.document.querySelector("#message_len").innerText="%s";
        if(len < %d){
            parent.document.querySelector("#music_go").click();
        }
    }
}
music();
function music_play(){
    var sound = new Howl({
        src: [ "https://author.lugeshop.com/sch/alert.mp3?v=1101211" ],
        autoplay: false,
        loop: false,
    });
    music_start = 0;
    try{
    valid = location.href.split('?');
    if(valid[1]=="1"){
        music_start = 1;
    }
    }catch(e){

    }
    if(music_start==0){
        sound.play();
        /*const videoPromise = document.querySelector("#mu");
        videoPromise.muted = false;
        videoPromise.play();*/
    }
}

</script>''' % (deer_index+kiki_index+1,str(deer_index+kiki_index+1),deer_index+kiki_index+1)
print(js_len)

def makekey(nn):
    tc = string.ascii_lowercase
    if nn==0:
        mk = tc[random.randint(0,25)]
    else:
        mk = str(random.randint(0,9))
    return mk

if mail_check > 0:
    userpassword = 'ZmYxMTM1NjI='
    mailpassword = 'rkqlnddzjgcqnhln'
    a = makekey(random.randint(0,1))
    b = makekey(random.randint(0,1))
    c = makekey(random.randint(0,1))
    d = makekey(random.randint(0,1))
    e = makekey(random.randint(0,1))
    f = makekey(random.randint(0,1))
    n = '%s%s%s%s%s%s' % (a,b,c,d,e,f)
    curl_script="""curl --ssl-reqd \\
      --url 'smtps://smtp.gmail.com:465' \\
      --user 'yencloudleader@gmail.com:{0}' \\
      --mail-from 'yencloudleader@gmail.com' \\
      --mail-rcpt 'bi1012037@gmail.com' \\
      --upload-file {1}.txt""".format(mailpassword,n)
    subject = u"%s有新訪客登入囉!" % now_time
    email_content = '請回日記簿查看狀態。'
    email_template="""From: "Lugeshop" <yencloudleader@gmail.com>
To: "bi1012037" <bi1012037@gmail.com>
Subject:{0}

{1}""".format(subject,email_content)
    with open("%s.txt" % n,'w',encoding="utf_8_sig") as f:
        f.write(email_template)
    os.system(curl_script)
    os.system("rm %s.txt" % n)
    """# 輸入gmail信箱的資訊
    userid = 'RjEyODc1MDIzMg=='
    username = 'YmkxMDEyMDM3'
    userpassword = ''
    host = "smtp.gmail.com"
    port = 587
    mailname = base64.b64decode("eWVuY2xvdWRsZWFkZXJAZ21haWwuY29t").decode("utf-8")
    mailpassword = base64.b64decode("").decode("utf-8")
    to_list = ["bi1012037@gmail.com"]
    from_email = mailname
    email_conn = smtplib.SMTP(host,port)
    # 試試看能否跟Gmail Server溝通
    #print(email_conn.ehlo())
    # TTLS安全認證機制
    email_conn.starttls()
    # 登錄mail
    ec = email_conn.login(mailname,mailpassword)
    #print(ec)
    #time.sleep(2)
    # 寄信
    the_msg = MIMEMultipart("alternative")
    # 開始郵件內容
    the_msg['Subject'] = u"%s有新訪客登入囉!" % now_time
    the_msg["From"] = mailname
    # 純文字部分
    html_txt = '請回日記簿查看狀態。'
    # 紀錄純文字加上HTML格式
    part_1 = MIMEText(html_txt, 'html', 'utf-8')
    the_msg.attach(part_1)
    #print(the_msg.as_string()
    email_conn.sendmail(from_email, to_list, the_msg.as_string())

    # 關閉連線
    email_conn.quit()

    #print('Email sent!')"""
