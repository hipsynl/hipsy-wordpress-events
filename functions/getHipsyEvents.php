<?php

function get_hipsy_events($key, $slug)
{
    $url = "https://api.hipsy.nl/v1/organisation/{$slug}/events";
    return fetch($key, $url);
}

function get_hipsy_organisations($key)
{
    $url = "https://api.hipsy.nl/v1/organisations/index";
    return fetch($key, $url);
}

/**
 * @param $key
 * @param string $url
 * @return mixed
 */
function fetch($key, string $url)
{
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
    if(!isset($events["data"]))
        return $events;
    return $events["data"];
}
