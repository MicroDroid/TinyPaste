<?php

$filelength = 5;

if ($_POST["code"]) {
	do {
		$filename = rtrim(strtr(base64_encode(generateRandomString($filelength)), "+/", "-_"), "=");
	} while (file_exists($filename));
	
	$f = fopen(dirname(dirname(__DIR__)) . "/pastes/" . $filename, "w");
	fwrite($f, $_POST["code"]);
	fclose($f);

	echo json_encode(array("status" => "200",
						"error" => "",
						"raw_link" => ($_SERVER["SERVER_NAME"] . '/r?q=' . $filename),
					 	"rich_link" => ($_SERVER["SERVER_NAME"] . '/p?q=' . $filename)));
} else {
	echo json_encode(array("status" => "400",
							"error" => "Missing code parameter"));
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>