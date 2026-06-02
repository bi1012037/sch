import os
if os.path.dirname(__file__) != '':
    os.chdir(os.path.dirname(__file__))

with os.popen('grep -r "一起吃" *') as f:
    fc = f.read()

print(fc)
