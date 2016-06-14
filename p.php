<!DOCTYPE html>
<html>
<head>
	<title>TinyPaste</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="EN">
	<meta name="keywords" content="code, paste, pastebin, snippet, save, store, txt, codebin">
	<link rel="icon" type="image/png" href="res/img/favicon.png">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/styles/androidstudio.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js"></script>
	<style>
		body {
			background: #222222;
		}
	</style>
</head>
<body>

<?php

if (!isset($_GET["q"])) {
	echo '<h1>Not found!</h1>';
	die();
}
else if (!file_exists("pastes/" . $_GET["q"])) {
	echo '<h1>It does not exist!</h1>';
	die();
}

$code = file_get_contents("pastes/" . $_GET["q"]);

echo '<pre><code>';
echo htmlspecialchars($code);
echo '</pre></code>';

?>

<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
