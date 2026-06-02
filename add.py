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
import subprocess
import json
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

if os.path.dirname(__file__) != '':
    os.chdir(os.path.dirname(__file__))

now_time = datetime.datetime.now()
now_time = now_time.strftime("%Y-%m-%d %X")
#time_check = now_time[0:18]
time_check = datetime.datetime.now()
fundnow = datetime.datetime.now()
fyear = fundnow.year
fmonth = fundnow.month
fday = fundnow.day
key = sys.argv[1].encode('utf-8', errors='surrogateescape').decode('utf-8')
key = key.split('_')
who = key[0]
who_status = key[1]
who_input = key[2]
who_ip = key[3]
try:
    version = key[4]
except:
     version = ""
status_dict={"0":"起床囉!",
             "1":"準備午餐中!",
             "2":"出門去!",
             "3":"工作中!",
             "4":"吃晚餐!",
             "5":"洗澡中!",
             "6":"愛睏中!",
             "7":"其他!"}

who_status_ck = ""
who_input_ck = ""
who_time = ""
try:
   with open("lst.txt","r",encoding="utf_8_sig") as v:
        #vc = eval(v.read())
        vc = json.load(v)
        for i in vc:
            index = i
            if vc[i]['who'] == who:
                who_status_ck = vc[i]['who_status']
                who_input_ck = vc[i]['who_input']
                who_time = vc[i]['who_time']
                who_time = datetime.datetime.strptime(who_time, "%Y-%m-%d %H:%M:%S")
        index = int(index)+1
except:
    os.system('echo {} > lst.txt')
    vc = {}
    index = 1

if who_status == "7" and who_input=="":
    #print("<script>alert('維護中!!!');</script>")
    sys.exit()
if who_status_ck == who_status and who_input_ck == who_input and (time_check-who_time).total_seconds()<10:
    #print("<script>console.log('阻擋重複訊息~');</script>")
    print("<script>alert('不要調皮，連續按太多次!!!');</script>")
    print("<script>parent.document.querySelector('#%s_send_input').value=''</script>" % who)
    sys.exit()

vc.setdefault( index ,"dafault")
vc[index]={"who_status":"%s" % who_status,"who_input":"%s" % who_input,"who_ip":"%s" % who_ip,"who_time":"%s" % now_time,"who":"%s" % who}
with open("lst.txt","w",encoding="utf_8_sig") as v:
    #v.write(str(vc))
    json.dump(vc, v, ensure_ascii=False)
clean_script='''<script>parent.document.querySelector('#%s_send_input').value='';</script>''' % who



if version != "2":
    if who=="kiki":
        js_script='''<script>parent.document.querySelector("#myframe2").src="https://author.lugeshop.com/sch/search.php"</script>'''
    else:
        js_script='''<script>parent.document.querySelector("#myframe2").src="https://author.lugeshop.com/sch/search_no_alert.php"</script>'''
else:
    js_script= '''<script>parent.renew();</script>'''
js2='''<script>parent.document.querySelector("#myframe").src='';</script>'''
#print(clean_script)
print(js_script)
print(js2)
def makekey(nn):
    tc = string.ascii_lowercase
    if nn==0:
        mk = tc[random.randint(0,25)]
    else:
        mk = str(random.randint(0,9))
    return mk
if who_status != "7":
    who_input = status_dict[who_status]

data = {
    "value1": "%s說:%s" % (who,who_input),
}
if who=="kiki":
    text_to_append = "%s,%s" % (now_time,who_input)
    with open("kiki.txt", "a", encoding="utf-8") as file:
        file.write(text_to_append + "\n")  # 添加换行符
    requests.get("https://author.lugeshop.com/discord.php?message=%s&channel=note" % data["value1"])
    requests.get("https://author.lugeshop.com/linev2.php?message=%s" % data["value1"])
