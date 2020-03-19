cd /var/www/html/app/code/Mlp/Cli/Console/Command/

iconv -f ISO-8859-1 -t UTF-8 tot_jlcb.csv > tot_jlcb_utf.csv

chown www-data:www-data tot_jlcb_utf.csv
chmod 777 tot_jlcb_utf.csv


