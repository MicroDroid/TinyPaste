<?php

$filepath = "pastes/" . $_GET["q"];

if (!file_exists($filepath))
	die();
$code = file_get_contents($filepath);
echo htmlspecialchars($code);

?>