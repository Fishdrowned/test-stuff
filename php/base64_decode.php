<?php
require __DIR__ . '/.include.php';
$code = getRequest('code');
$functions = array(
	'decode' => 'base64_decode',
	'encode' => 'base64_encode',
	'md5' => 'md5',
	'rawurlencode' => 'rawurlencode',
	'jsonDecode' => 'jsonDecode',
	'base36' => 'base36',
	'reverseBase36' => 'reverseBase36',
);
/* @var string $func one of $functions */
$func = fnGet($functions, getRequest('type'), getRequest('type'));

function jsonDecode($data) {
	return var_export(json_decode($data, true), true);
}

function base36($value) {
	return base_convert($value, 10, 36);
}

function digitSum($value) {
	$sum = array_sum(str_split($value));
	return $sum > 10 ? digitSum($sum) : $sum;
}

/**
 * 生成随机字符串
 * @param int $length
 * @return string
 */
function randString($length = 3) {
	return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz123456789'), 0, $length);
}

/**
 * 把一个整数编码成为一串无意义的字符串
 * @param int $value 要编码的整数
 * @param int $key   钥匙，一个比较大的整数
 * @param int $jam   干扰字符串位数
 * @return string
 */
function intHashEncode($value, $key = 1000000001, $jam = 3) {
	return randString($jam) . base_convert(strrev($value * 10 + $key), 10, 36) . randString($jam);
}

/**
 * 把经过 intHashEncode 编码的字符串反编码为整数
 * @param string $value 经过 intHashEncode 编码的字符串
 * @param int $key      钥匙
 * @param int $jam      干扰字符串位数
 * @return int
 */
function intHashDecode($value, $key = 1000000001, $jam = 3) {
	return (int)((strrev(base_convert(substr($value, $jam, -$jam), 36, 10)) - $key) / 10);
}

function checkPasswordHash($value) {
	list($password, $hash) = explode(',', $value);
	return $password . ', ' . $hash . ': ' . var_export(password_verify($password, $hash), 1);
}

function varUnserialize($value) {
	$result = unserialize($value);
	return is_scalar($result) ? $result : var_export($result, 1);
}

function base64GzDeflate($value) {
    return base64_encode(gzdeflate($value, 9));
}

function base64GzInflate($value) {
    return gzinflate(base64_decode($value));
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Base64 Decode</title>
	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
	<p><label>Input code:<br/><textarea name="code" cols="200" rows="20"><?php echo $code; ?></textarea></label></p>
	<p>
		<button type="submit" name="type" value="decode">Base64 Decode</button>
		<button type="submit" name="type" value="encode">Base64 Encode</button>
		<button type="submit" name="type" value="md5">MD5</button>
		<button type="submit" name="type" value="rawurlencode">Raw URL Encode</button>
		<button type="submit" name="type" value="jsonDecode">JSON Decode</button>
		<button type="submit" name="type" value="serialize">serialize</button>
		<button type="submit" name="type" value="varUnserialize">unserialize</button>
		<button type="submit" name="type" value="base36">base36</button>
		<button type="submit" name="type" value="intHashEncode">intHashEncode</button>
		<button type="submit" name="type" value="intHashDecode">intHashDecode</button>
		<button type="submit" name="type" value="checkPasswordHash">checkPasswordHash</button>
        <button type="submit" name="type" value="base64GzDeflate">base64GzDeflate</button>
        <button type="submit" name="type" value="base64GzInflate">base64GzInflate</button>
	</p>
</form>
<div>
	<label>Result:<br/><textarea cols="200" rows="20"><?php echo strlen($code) ? $func($code) : ''; ?></textarea></label>
</div>
</body>
</html>
