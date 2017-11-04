<?php
include_once "dbcon.php";
$con = new DB_con();

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

$tablet_browser = 0;
$mobile_browser = 0;

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
    'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
    'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
    'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
    'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
    'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
    'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
    'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
    'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

if (in_array($mobile_ua, $mobile_agents)) {
    $mobile_browser++;
}

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
        $tablet_browser++;
    }
}

if ($tablet_browser > 0) {
    // do something for tablet devices
    $device = 'tablet';
} else if ($mobile_browser > 0) {
    // do something for mobile devices
    $device = 'mobile';
} else {
    // do something for everything else
    $device = 'desktop';
}


if (isset($_POST['submit1'])) {
    unset($_POST['submit1']);
    $err_val = array("error", "nominated0", "r_address", "f_contact", "p_contact", "created_date");
    foreach ($_POST as $key => $value) {
        $data[$key] = addslashes(trim($value));
    }
    $allowedExts = array("jpeg", "png", "jpg", "JPEG", "PNG", "JPG", "docx", "doc", "pdf");
    if (isset($_FILES['photo_img'])) {
        $data['photo_img'] = "";
        for ($a = 0; $a < count($_FILES['photo_img']['name']); $a++) {
            $file_name = $_FILES['photo_img'];
            $fname = $file_name["name"][$a];
            $rawBaseName = pathinfo($fname, PATHINFO_FILENAME);
            $extension = pathinfo($fname, PATHINFO_EXTENSION);
            if (($file_name["size"][$a] < 20000000) && in_array($extension, $allowedExts)) {
                if ($file_name["error"][$a] > 0) {
                    echo "Return Code: " . $file_name["error"][$a] . "<br>";
                } else {
                    $target_dir = "document/";
                    $counter = 0;
                    while (file_exists($target_dir . $fname)) {
                        $fname = $rawBaseName . $counter . '.' . $extension;
                        $counter++;
                    }

                    if (move_uploaded_file($file_name["tmp_name"][$a], $target_dir . $fname)) {
                        $data['photo_img'] .= $target_dir . $fname . ',';
                    } else {
                        $data['photo_img'] .= "";
                    }
                }
            }
        }
    }
    $allowedExts1 = array("jpeg", "png", "jpg", "JPEG", "PNG", "JPG", "docx", "DOCX", "pdf", "PDF", "doc");
    if (isset($_FILES['attach_award'])) {
        $data['attach_award'] = "";
        for ($b = 0; $b < count($_FILES['attach_award']['name']); $b++) {
            $file_name1 = $_FILES['attach_award'];
            $fname1 = $file_name1["name"][$b];
            $rawBaseName1 = pathinfo($fname1, PATHINFO_FILENAME);
            $extension1 = pathinfo($fname1, PATHINFO_EXTENSION);
            if (($file_name1["size"][$b] < 20000000) && in_array($extension1, $allowedExts1)) {
                if ($file_name1["error"][$b] > 0) {
                    echo "Return Code: " . $file_name1["error"][$b] . "<br>";
                } else {
                    $target_dir1 = "document/";
                    $counter1 = 0;
                    while (file_exists($target_dir1 . $fname1)) {
                        $fname1 = $rawBaseName1 . $counter1 . '.' . $extension1;
                        $counter1++;
                    }

                    if (move_uploaded_file($file_name1["tmp_name"][$b], $target_dir1 . $fname1)) {
                        $data['attach_award'] .= $target_dir1 . $fname1 . ',';
                    } else {
                        $data['attach_award'] .= "";
                    }
                }
            }
        }
    }

    $ua = getBrowser();
    $data['user_agent'] = $ua['name'] . "-" . $ua['version'] . "-" . $ua['platform'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $data['ip'] = $ip;
    $data['created_date'] = date("Y-m-d H:i:s");
    $data['device'] = $device;
    $id = $con->insert("iim_alumini4", $data);
    if (is_numeric($id)) {
        $con->close_con();
        echo '<span class="alert alert-success">
                                Thank you for your time and efforts for filling up the nomination form. We might contact you for any further clarification if needed. The survey is conducted in association with
                    <a href="https://beta.indiaopendata.com/">www.indiaopendata.com</a>        </span>';
        echo"<br>";
    } else {
        $n = 0;
        foreach ($err_val as $value) {
            $n++;
            if ($n == 1) {
                $err_val1[$value] = addslashes($id);
            } else {
                $err_val1[$value] = $data[$value];
            }
        }
        $id = $con->insert("iim_alumini4", $err_val1);
        $con->close_con();
        echo "<br/> not Submitted";
    }
}
?>
<br>
<a href="https://beta.indiaopendata.com/"> <img class="logo py-1" src="images/ioda-logo.png" /> </a>
<style>
    .logo {
        max-height: 60px;
    }
    .py-1 {
        padding-top: .25rem!important;
        padding-bottom: .25rem!important;
    }
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
</style>