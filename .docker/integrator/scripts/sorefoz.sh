cd /var/www/html/app/code/Mlp/Cli/Console/Command

HOST='www.sorefoz.pt'
USER='loj0078'
PASSWD='nyvt64#'
FILE='tot_jlcb.csv'
ftp -pn $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASSWD
get $FILE
quit

END_SCRIPT
exit 0

