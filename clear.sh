mv /var/www/html/sch/lst.txt /var/www/html/sch/history/$(date -d "yesterday" +%Y-%m-%d).txt
touch /var/www/html/sch/lst.txt
/usr/bin/python3 /var/www/html/sch/upload/dd.py
/usr/bin/python3 /var/www/html/sch/history/dd.py
mkdir /var/www/html/sch/upload/$(date -d "today" +%Y%m%d)
chown -R www-data:www-data /var/www/html/sch/*
#echo '' > /var/www/html/sch/search.txt
