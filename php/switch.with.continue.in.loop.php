<?php
highlight_file(__FILE__);
for ($i = 0, $count = 5; $i < $count; ++$i) {
	var_dump($i);
}
for ($i = 0, $count = 5; $i < $count; ++$i) {
	switch (1) {
		case 1:
			echo 'Switch';
			continue;
		case 2:
			echo 'NEVER REACH THIS';
			break;
	}
	var_dump($i);
}
#====================== OUTPUT BELOW ======================
