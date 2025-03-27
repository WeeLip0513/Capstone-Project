<?php
function calculateFare($pickup, $dropoff, $time)
{
    $fares = [
        "lrt_bukit_jalil-apu" => 2,
        "apu-lrt_bukit_jalil" => 2,
        "apu-pav_bukit_jalil" => 4,
        "pav_bukit_jalil-apu" => 4,
        "apu-sri_petaling" => 4,
        "sri_petaling-apu" => 4,
        "pav_bukit_jalil-sri_petaling" => 5,
        "sri_petaling-pav_bukit_jalil" => 5,
        "lrt_bukit_jalil-pav_bukit_jalil" => 5,
        "pav_bukit_jalil-lrt_bukit_jalil" => 5
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
