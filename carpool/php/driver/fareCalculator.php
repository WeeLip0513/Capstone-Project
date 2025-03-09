<?php
function calculateFare($pickup, $dropoff, $time)
{
    $fares = [
        "lrt_bukit_jalil-apu" => 4,
        "apu-lrt_bukit_jalil" => 4,
        "apu-pav_bukit_jalil" => 7,
        "pav_bukit_jalil-apu" => 7,
        "apu-sri_petaling" => 7,
        "sri_petaling-apu" => 7,
        "pav_bukit_jalil-sri_petaling" => 7,
        "sri_petaling-pav_bukit_jalil" => 7,
    ];

    // Format input to match keys
    $routeKey = strtolower("$pickup-$dropoff");

    if (!isset($fares[$routeKey])) {
        return "Invalid route selected.";
    }

    $fare = $fares[$routeKey];

    // Apply peak hour surcharge (18:00 - 20:00)
    $hour = (int) date("H", strtotime($time));
    if ($hour >= 18 && $hour < 20) {
        $fare *= 1.2; // Increase by 20%
    }

    return round($fare, 2);
}
?>
