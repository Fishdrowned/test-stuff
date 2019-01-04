#!/usr/bin/env bash

usage() {
    echo "$0 [--dev|-d]"
}
DEV=0

# {------
# Support long options: https://stackoverflow.com/a/35235757/802646
args=( )

for arg; do
    case "$arg" in
        --help)           args+=( -h ) ;;
        --dev)            args+=( -d ) ;;
        --*)              echo $0: illegal option ${arg} >&2; exit 1;;
        *)                args+=( "$arg" ) ;;
    esac
done

set -- "${args[@]}"

while getopts "hd" OPTION; do
    : "$OPTION" "$OPTARG"
    case ${OPTION} in
        h)  usage; exit 0;;
        d)  DEV=1;;
    esac
done
# ------}

echo Dev mode: ${DEV}
