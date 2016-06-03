<?php
include __DIR__ . '/.include.php';
if ($data = getRequest('data')) {
	$data = json_decode($data, true);
	echo http_build_query($data);
}
?>
<form method="post" enctype="application/x-www-form-urlencoded" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
	<p><label>Content: <textarea name="data"><?php echo getRequest('data'); ?></textarea></label></p>
	<p><button type="submit">Submit</button></p>
</form>
