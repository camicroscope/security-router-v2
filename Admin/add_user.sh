#!/bin/bash


if [ $# -eq 1 ] && [ $1 == "help" ]
then
   echo $0 "<IMS Name/username/name> <email address> <key expiration data mm/dd/yyyy> <bindaas trusted secret[optional]> <bindaas trustedApplication url [optional]>"
   exit 0;
elif [ $# -eq 0 ] || [ $# -ne 3 ]
then
    echo "Usage: $0 <IMS Name/username/name> <email address> <key expiration data mm/dd/yyyy> <bindaas trusted secret[optional]> <bindaas trustedApplication url [optional]>"
    exit;
fi
USERNAME="$2"
COMMENT="'Account for $1 created by Security/Admin/add_user.sh'"
EXP_DATE="$3"
SECRET="${4:-'9002eaf56-90a5-4257-8665-6341a5f77107'}"
URL="${5:-'http://quip-data:9099/trustedApplication'}"
COMMAND="java -jar trusted-app-client-0.0.1-jar-with-dependencies.jar -action a -username $USERNAME  -id camicSignup -secret $SECRET -comments $COMMENT -expires $EXP_DATE  -url $URL"
#echo $COMMAND
eval $COMMAND
