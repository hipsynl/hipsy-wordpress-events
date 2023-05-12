<?php

function get_hipsy_events($key, $slug)
{
    $url = "https://api.hipsy.nl/v1/organisation/{$slug}/events";
    $headers = array(
        "Authorization: Bearer {$key}"
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $events = json_decode($response, true);

    return $events["data"];
}
