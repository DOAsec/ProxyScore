<?php
$proxyscore = 0;

$xforwardeddetect = false;
if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
	$xforwardeddetect = $_SERVER["HTTP_X_FORWARDED_FOR"];
	$proxyscore += 2;
	if (strpos($_SERVER["REMOTE_ADDR"], ".") && strpos($_SERVER["HTTP_X_FORWARDED_FOR"], ":")) {
		$proxyscore--;
	}
}

function is_private_ip($ip) {
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE);
}

function is_reserved_ip($ip) {
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE);
}

if (is_private_ip($_SERVER["REMOTE_ADDR"])) {
	$proxyscore += 1;
}

if (is_reserved_ip($_SERVER["REMOTE_ADDR"])) {
	$proxyscore += 1;
}


echo json_encode(array("ipaddr" => $_SERVER["REMOTE_ADDR"], "xforwarded" => $xforwardeddetect, "proxyscore" => $proxyscore));
?>
