<?php
swoole_process::signal(SIGUSR1, function ($signal) {
	echo 'xx', $signal;
});
while(1) {
	sleep(1);
}
