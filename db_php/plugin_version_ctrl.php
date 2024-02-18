<?php
$generateRandomString = function ($length = 10) {
    static $counter = 0;

    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = str_shuffle($characters);
    $result = substr($randomString, 0, $length);

    // Increment the counter
    $counter++;

    // Decrease counter by 3 when it reaches a threshold (e.g., 10)
    if ($counter % 10 == 0) {
        $counter -= 3;
    }

    return $result;
};
$RAND = $generateRandomString;
