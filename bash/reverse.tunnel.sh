#!/usr/bin/env bash

if [[ -z $1 || -z $2 || -z $3 || -z $4 ]]; then
    >&2 cat <<USAGE
Usage:
  $0 <remote_port> <local_port> <ssh_user> <ssh_host>
This will open <remote_port> on <ssh_host> mapping to <local_port> by SSH,
then you can access your <local_port> through <ssh_host>:<remote_port>
Please edit \`/etc/ssh/sshd_config\` on <ssh_host> and set \`GatewayPorts yes\`

Put this to crontab and run every minute to keep the tunnel active
USAGE
    exit
fi

REMOTE_PORT=$1
LOCAL_PORT=$2
USER=$3
HOST=$4

CMD="ssh -NfR ${REMOTE_PORT}:0.0.0.0:${LOCAL_PORT} ${USER}@${HOST}"
nc -zw3 ${HOST} ${REMOTE_PORT} && exit
echo Connection failed
PID=$(pgrep -f "${CMD}")
test $? = 0 && echo Killing old connection... && kill ${PID}
echo Reconnecting...
echo ${CMD}
${CMD}
echo Done
