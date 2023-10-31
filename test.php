<?php

function randomDatetimeBetweenDates($startDate, $endDate) {
    // Convert the start and end dates to timestamps.
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    // Calculate the difference between the start and end timestamps.
    $timeDiff = $endTimestamp - $startTimestamp;

    // Generate a random number between 0 and the difference in timestamps.
    $randomOffset = mt_rand(0, $timeDiff);

    // Add the random offset to the start timestamp to get a random datetime.
    $randomDatetime = $startTimestamp + $randomOffset;

    // Return the random datetime as a DateTime object.
    return new DateTime($randomDatetime);
}

$startDate = '2023-01-01';
$endDate = '2023-12-31';

$randomDatetime = randomDatetimeBetweenDates($startDate, $endDate);

echo $randomDatetime->format('Y-m-d H:i:s');


?>
