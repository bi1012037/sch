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
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

if os.path.dirname(__file__) != '':
    os.chdir(os.path.dirname(__file__))

key = sys.argv[1].encode('utf-8', errors='surrogateescape').decode('utf-8')
key = key.split('_')
who = key[0]
who_id = key[1]

try:
    with open("%s.txt" % who,"r",encoding="utf_8_sig") as v:
        #vc = eval(v.read())
        vc = json.load(v)
except:
    os.system('echo {} > %s.txt' % who)
    vc = {}

del vc[who_id]
with open("%s.txt" % who,"w",encoding="utf_8_sig") as v:
    #v.write(str(vc))
    json.dump(vc, v, ensure_ascii=False)
#js_script='''<script>parent.document.location.href="https://author.lugeshop.com/sch/search.php?who=%s"</script>''' % who
js_script='''<script>parent.document.querySelector("#myframe2").src="https://author.lugeshop.com/sch/search_no_alert.php"</script>'''
#print(js_script)

