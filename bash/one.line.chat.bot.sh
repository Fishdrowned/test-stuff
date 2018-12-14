#!/usr/bin/env bash
while true; do read -p '> ' QUESTION; echo "$(echo "${QUESTION}" | sed 's/吗\|？\|?//g')!"; done
