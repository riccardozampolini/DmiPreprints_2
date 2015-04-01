<?php

#funzione per la verifica se il nome è stato cercato nell'ultima esecuzione

function nomiprec($nome) {
    #cerca se il nome se era stato gia cercato...
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/nomi_ultimo_lancio.txt";
    #apertura con fopen del file nomi_ultimo_lancio.txt
    $fs = fopen($s, "r");
    #conto il numero di nomi
    $nl = count(file($s));
    $array = file($s);
    #chiusura di fopen
    fclose($fs);
    #ricerca del nome
    for ($i = 0; $i < $nl; $i++) {
        $nomi = $array[$i];
        $nomi = trim($nomi);
        if ($nome == $nomi) {
            return True;
            break;
        }
    }
    return False;
}

#funzione che cerca se il preprint è stato già scaricato...

function preprintscaricati($id) {
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/temp.txt";
    $fs = fopen($s, "r");
    $nl = count(file($s));
    $array = file($s);
    fclose($fs);
    #cerca il preprint se è stato già scaricato
    for ($i = 0; $i < $nl; $i++) {
        $idprec = $array[$i];
        $idprec = trim($idprec);
        if ($id == $idprec) {
            return True;
            break;
        }
    }
    return False;
}

#funzione per l'inserimento dell'id dentro il file temp.txt

function aggiornapreprintscaricati($id) {
    #leggo i preprint e li inserisco in array...
    $c = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/temp.txt";
    $fp = fopen($c, "r");
    $array = file($c);
    fclose($fp);
    array_push($array, $id . "\n");
    $nl = count($array);
    #aggiorno il file preprintscaricati.txt...
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/temp.txt";
    $fs = fopen($s, "w+");
    for ($i = 0; $i < $nl; $i++) {
        fwrite($fs, $array[$i]);
    }
    fclose($fs);
}

#funzione per la cancellazione del contenuto di file temp.txt

function azzerapreprint() {
    #azzero la variabile temp.txt...
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/temp.txt";
    $fs = fopen($s, "w+");
    fwrite($fs, "");
    fclose($fs);
}

#funzione che cerca se il nome è presente...

function cercanome($nome) {
    $array = legginomi();
    $nl = count($array);
    #ricerca del nome se esistente
    for ($i = 0; $i < $nl; $i++) {
        $nomi = $array[$i];
        $nomi = trim($nomi);
        if ($nome == $nomi) {
            return True;
            break;
        }
    }
    return False;
}

#funzione aggiornamento file nomi_ultimo_lancio.txt

function aggiornanomi() {
    #leggo i nuovi nomi e li inserisco in array...
    $array = legginomi();
    $nl = count($array);
    #aggiorno il file nomi.txt...
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/nomi_ultimo_lancio.txt";
    $fs = fopen($s, "w+");
    for ($i = 0; $i < $nl; $i++) {
        $data = fwrite($fs, $array[$i]);
    }
    fclose($fs);
}

# funzione lettura nomi dal file nomi.txt

function legginomi() {
    #leggo i nuovi nomi e li inserisco in array...
    $c = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/nomi.txt";
    $fp = fopen($c, "r");
    $array = file($c);
    fclose($fp);
    #ritorno l'array contenente i nomi...
    return $array;
}

#funzione scrittura nomi in file nomi.txt

function scrivinomi($nomi) {
    #leggo i nuovi nomi e li inserisco nel file di testo...
    $nl2 = count($nomi);
    $s = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/nomi.txt";
    $fs = fopen($s, "w+");
    for ($i = 0; $i < $nl2; $i++) {
        $data = fwrite($fs, $nomi[$i]);
    }
    fclose($fs);
}

#funzione inserimento nuovo utente

function aggiungiutente($nome) {
    #leggo i nuovi nomi e li inserisco in array...
    $array = legginomi();
    $array2 = explode(",", $nome);
    $nl = count($array2);
    $modificato = False;
    for ($i = 0; $i < $nl; $i++) {
        $temp = $array2[$i];
        $temp = trim($temp);
        $temp = strtoupper($temp);
        #verifico se il nome è già presente...
        $ris = cercanome($temp);
        if ($ris == FALSE) {
            $temp = $temp . "\n";
            array_push($array, $temp);
            $modificato = True;
            echo "<center>" . $temp . " INSERTED IN LIST!</center><br/>";
        } else {
            echo "<center>" . $temp . " ALREADY EXISTS!</center><br/>";
        }
    }
    #aggiorno il file nomi.txt se ci sono nomi da aggiungere...
    if ($modificato == True) {
        scrivinomi($array);
    }
}

#ritorno la data come intero

function dataprec() {
    #lettura del file data_ultimo_lancio.txt
    $c = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/data_ultimo_lancio.txt";
    $fp = fopen($c, "r");
    $data = fgets($fp, 5096);
    fclose($fp);
    $data = trim($data);
    $data = substr($data, 0, 10);
    $data = str_replace("-", "", $data);
    #conversione della stringa in intero
    $data = intval($data);
    return $data;
}

#ritorno la data come una stringa

function datastring() {
    $c = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/data_ultimo_lancio.txt";
    $fp = fopen($c, "r");
    $data = fgets($fp, 5096);
    fclose($fp);
    return $data;
}

#aggiorno il file data_ultimo_lancio.txt con la data di ultimo lancio

function aggiornadata() {
    $a = date("Y-m-d", time());
    $c = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/data_ultimo_lancio.txt";
    $fp = fopen($c, "w+");
    $data = fwrite($fp, $a);
    fclose($fp);
}

?>
