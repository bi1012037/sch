import json

#with open("lst.txt.cp","r",encoding="utf_8_sig") as v:
#    vc = eval(v.read())

#with open("lst.txt","w",encoding="utf_8_sig") as v:
#    json.dump(vc, v, ensure_ascii=False)


with open("lst.txt","r",encoding="utf_8_sig") as v:
    #vc = eval(v.read())
    vc = json.load(v)
    for i in vc:
        index = i
        print(i)
