<?php
require __DIR__ . '/.include.php';
$value = getRequest('value');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Unserialize</title>
	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
	<p><label>Input value:<br/><textarea name="value" cols="200" rows="20"><?php echo $value; ?></textarea></label></p>
	<p><button type="submit">Devalue</button></p>
</form>
<div>
	<label>Result:<br/><textarea cols="200" rows="20"><?php var_export($value ? unserialize($value) : ''); ?></textarea></label>
</div>
</body>
</html>
