<?php
//ini_set('enable_post_data_reading', false);
include __DIR__ . '/.include.php';

var_dump($_REQUEST, file_get_contents('php://input'));
?>
<form method="post" action="<?php echo fnGet($_SERVER, 'SCRIPT_NAME'); ?>" target="_self" enctype="multipart/form-data">
	<p><label>Content: <input type="text" name="content" value="<?php echo getRequest('content'); ?>"></label></p>
	<p><button type="submit">Submit</button></p>
</form>
