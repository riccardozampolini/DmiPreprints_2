<?php

#funzione per download dei pdf

function curl_download($url, $path) {
    $ch = curl_init($url);
    if ($ch === false) {
        die('Failed to create curl handle');
    }
    $fp = fopen($path, 'w');
    $ch = curl_init($url);
    $userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.11) Gecko/20071204 Ubuntu/7.10 (gutsy) Firefox/2.0.0.11';
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    $data = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

?>
