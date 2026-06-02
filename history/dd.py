import os
from os import listdir
from os.path import isfile, isdir, join
if os.path.dirname(__file__) != '':
    os.chdir(os.path.dirname(__file__))
import datetime
now_time = datetime.datetime.now()
now_time = now_time.strftime("%Y%m%d")
mypath = "."
# 取得所有檔案與子目錄名稱
files = listdir(mypath)

# 以迴圈處理
for f in files:
  # 產生檔案的絕對路徑
  fullpath = join(mypath, f)
  # 判斷 fullpath 是檔案還是目錄
  if os.path.getsize(fullpath)==0 or os.path.getsize(fullpath)==3 or os.path.getsize(fullpath)==5:
      os.system("rm -rf %s" % fullpath)
  """if isdir(fullpath):
      #print(fullpath)
      with os.popen("ls -l %s" % f,"r") as p:
          result = p.read()
          #print(result)
      if ("total 0" in result or "總計 0" in result) and f != now_time:
          os.system("rm -rf %s" % f)"""

