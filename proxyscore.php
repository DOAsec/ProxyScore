<?php
class ProxyScore {
    public $proxyscore = 0;

    public $xforwardeddetect = false;


    public function is_private_ip($ip) {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE);
    }

    public function is_reserved_ip($ip) {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE);
    }

    public function getScoreJSON() {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $this->$xforwardeddetect = $_SERVER["HTTP_X_FORWARDED_FOR"];
            $this->$proxyscore += 2;
            if (strpos($_SERVER["REMOTE_ADDR"], ".") && strpos($_SERVER["HTTP_X_FORWARDED_FOR"], ":")) {
                    $this->$proxyscore--;
            }
        }

        if ($this->is_private_ip($_SERVER["REMOTE_ADDR"])) {
                $this->$proxyscore += 1;
        }

        if ($this->is_reserved_ip($_SERVER["REMOTE_ADDR"])) {
                $this->$proxyscore += 1;
        }

        return json_encode(array("ipaddr" => $_SERVER["REMOTE_ADDR"], "xforwarded" => $xforwardeddetect, "proxyscore" => $proxyscore));
    }
}

$ps = new ProxyScore();

echo $ps->getScoreJSON();

?>
