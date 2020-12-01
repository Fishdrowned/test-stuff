#!/usr/bin/env bash

if [[ -z $1 || -z $2 || -z $3 || -z $4 || -z $5 ]]; then
    >&2 cat <<USAGE
Usage:
  $0 <remote_host> <remote_port> <local_port> <ssh_user> <ssh_host>
This will map <remote_host>:<remote_port> to <local_port> by SSH over <ssh_host>,
then you can access the <remote_host>:<remote_port> through <localhost>:<local_port>
Please edit \`/etc/ssh/sshd_config\` on <ssh_host> and set \`GatewayPorts yes\`

Put this to crontab and run every minute to keep the tunnel active
USAGE
    exit
fi

REMOTE_HOST=$1
REMOTE_PORT=$2
LOCAL_PORT=$3
USER=$4
HOST=$5

CMD="ssh -NfL ${LOCAL_PORT}:${REMOTE_HOST}:${REMOTE_PORT} ${USER}@${HOST}"
nc -zw3 127.0.0.1 ${LOCAL_PORT} && exit
echo Connection failed
PID=$(pgrep -f "${CMD}")
test $? = 0 && echo Killing old connection... && kill ${PID}
echo Reconnecting...
echo ${CMD}
${CMD}
echo Done
