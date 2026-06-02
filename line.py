import requests
url = "https://maker.ifttt.com/trigger/Alert/with/key/bSH9xED1ZjuA-M74D-cDdk"
headers = {
    "Content-Type": "application/json"
}
data = {
    "value1": "test",
}
#requests.post(url, headers=headers, json=data)

key="wdnGYRphdv0HEa7M21PmnCBlk4wCFsQ1t1EWEPb5tAQ"
headers = {
    "Authorization": "Bearer " + key,
    "Content-Type": "application/x-www-form-urlencoded"
}
data2 = {
    "message": "test"
}
url =" https://notify-api.line.me/api/notify"
#response = requests.post(url, headers=headers, data=data)
#requests.get("https://author.lugeshop.com/line.php?message="+"你好")
requests.get("https://author.lugeshop.com/line.php?message=%s" % data["value1"])
#requests.get("https://author.lugeshop.com/line.php?message=日記簿 有訪客進入，請回來查看！")
