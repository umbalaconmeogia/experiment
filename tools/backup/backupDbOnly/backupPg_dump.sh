#!/bin/sh

cd `dirname $0`
DB_NAME=example_db
DATE=`date "+%Y%m%d_%H%M%S"`

pg_dump -U $DB_NAME -Fc $DB_NAME > ${DB_NAME}_${DATE}.pg_dump

# Contab
# 0 1 * * * /home/example/bin/backup/backupPg_dump.sh