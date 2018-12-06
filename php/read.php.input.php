<?php
var_dump(file_get_contents('php://input'));
var_dump(file_get_contents('php://input'));
?>
<form method="post">
    <input name="k" value="v">
    <button>Submit</button>
</form>
