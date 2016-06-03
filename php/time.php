<?php
include __DIR__ . '/.include.php';

var_dump(date('Y-n-j H:i:s', $time = (int)fnGet($_REQUEST, 'time', time())), $time);
?>
<form action="<?php echo fnGet($_SERVER, 'SCRIPT_NAME'); ?>" method="get" target="_self">
	<p><label><input type="text" name="time" value="<?php echo $time; ?>"></label></p>
	<p><button type="submit">Submit</button></p>
</form>
