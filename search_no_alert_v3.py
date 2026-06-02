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
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import json
#from selenium.webdriver.common.keys import Keys
#from selenium import webdriver
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
in_index = 0
try:
    in_index = sys.argv[2]
except:
    in_index = 0

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
    height: 100%;
}
body::-webkit-scrollbar {
    display: none;
}
.font_color{
    color:white;
}
#sch_width,#sch_width2{
    width:100%;
}
@media screen and (min-width: 768px){
    #sch_width,#sch_width2{
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
        document.querySelector("#myframe").src="https://author.lugeshop.com/sch/delete.php?who="+ele+"&status_id="+ele_id+"&v=2";
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
except:
    os.system('echo {} > %s.txt' % name)
    vc = {}
print('<div id="deer_form" align="center" ><table id="sch_width2" class="form_line font_color" cellspacing=0 cellpadding=0>')
print('<tr><td width="15%" align="center">編號</td><td width="40%">狀態</td><td>操作時間</td><td align="center" width="10%">刪除</td></tr>')
test = sorted(vc.keys(), key=lambda x: int(x),reverse = True)
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
        urls = re.findall(r'(?<![=])https?://[^\s<>"]+', clean_message)
        for i in urls:
             if "http" in i:
                 #url_index += 1
                 #url = i.replace("{","").replace("}","")
                 url = i
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
#print('<iframe id="myframe" name="myframe" height="100%" width="100%" frameborder="0" style="display:none;" scrolling="no"></iframe>')
if in_index == "first":
    print('<script>document.querySelector("#message_len").innerText=%s;</script>' % str(deer_index+kiki_index))

