#!/usr/bin/env bash
cd "$(dirname "${BASH_SOURCE[0]}")"

PHP56='php5.6 perf.loop.php'
PHP70='php7.0 perf.loop.php'
echo ${PHP56};
${PHP56}
echo ${PHP70};
${PHP70}
