#!/bin/bash

# ----------------------------------------------------
# A Shell script to take MySql database backup 
# and upload to MEGA cloud storage using megatools
# ----------------------------------------------------
# REQUIREMENTS : You should have -
# 1. Registered and verified MEGA account - https://mega.nz/
# 2. Installed megatools - https://github.com/megous/megatools
# ----------------------------------------------------
# This script is part of this tutorial - http://wp.me/p2nCeQ-a2
# ----------------------------------------------------

# CONFIG - Set you information here
db_user=ncm
db_pass=CvN9qLGMFxrMLOBh
db_name=ncm
mega_user=wa0tjt@gmail.com
mega_pass=1952tjt0AW
mega_path=/Root/DB_BACKUP
# NOTE: MEGA remote path should start with /Root/

# Create a temporary file
tmpfile=$(mktemp)
printf "Created temporary file: ${tmpfile} \n"

# Create Database dump and write to tmp file
printf "Writing database dump to tmp file..."
mysqldump -u ${db_user} -p${db_pass} ${db_name} > ${tmpfile}
printf " Done. \n"

# Upload dump file to MEGA cloud storage
printf "Uploading at ${mega_path}/${db_name}_$(date '+%Y-%m-%d-%H-%M').sql \n"
# Comment out next line if directory is already created for mega_path
megamkdir -u ${mega_user} -p ${mega_pass} ${mega_path}
megaput --no-progress -u ${mega_user} -p ${mega_pass} --path ${mega_path}/${db_name}_$(date '+%Y-%m-%d-%H-%M').sql ${tmpfile}

printf "Cleanup... "
rm ${tmpfile}
printf " Done. \n"