<?php

function curl_download($Url, $destination) {
    # verifico se cURL è installato
    if (!function_exists('curl_init')) {
        die('Sorry cURL is not installed!');
    }
    $file = fopen($destination, "w+");
    # si crea un cURL resource handle
    $ch = curl_init();
    # Impostazione di alcuni parametri
    # URL da scaricare
    curl_setopt($ch, CURLOPT_URL, $Url);
    # impostazione referer
    curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/pdf/yay.pdf");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
    # User agent per simulare un browser
    $userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.11) Gecko/20071204 Ubuntu/7.10 (gutsy) Firefox/2.0.0.11';
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    # Includere header nel result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
    # Imposto true per ritornare dati (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    # Timeout di 10 secondi
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FILE, $file);
    # Download dall'URL e return l'output
    curl_exec($ch);
    # Chiusura di cURL resource
    curl_close($ch);
    # chiusura di fopen
    fclose($file);
}

?>
