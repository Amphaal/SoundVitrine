<?php

use Ahc\Jwt\JWT;

function getSSETopic_shout(string $fromUsername)
{
    return sprintf(SHOUT_SSE_TOPIC_URI_TEMPLATE, $fromUsername);
}

/**
 * @param string $fromUsername from which user came the shout
 * @param mixed $shout shout data
 */
function sendSSEEvent_shout(string $fromUsername, mixed $shout)
{
    return sendSSEEvent_GENERIC(getSSETopic_shout($fromUsername), $shout);
}

//
function sendSSEEvent_GENERIC(string $topic, mixed $data): string|false
{

    // Instantiate with key and algo.
    $jwt = new JWT(getenv("MERCURE_PUBLISHER_JWT_KEY"), 'HS256');
    $token = $jwt->encode([
        "mercure" => [
            "publish" => ["*"]
        ]
    ]);

    $data = http_build_query([
        'topic' => $topic,
        'data' => json_encode($data)
    ]);
    $options = [
        'http' => [
            'header' => implode("\r\n", [
                "Content-type: application/x-www-form-urlencoded",
                "Content-Length: " . strlen($data),
                "Authorization: Bearer " . $token,
            ]) . "\r\n",
            'method' => 'POST',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents(MERCURE_LOCAL_URL, false, $context);
    return $result;
}

//
function getSSESubscriberJWT(): string
{
    $token = (new JWT(getenv("MERCURE_SUBSCRIBER_JWT_KEY"), 'HS256'))->encode([
        "d" => date("c"),
        "r" => rand(),
    ]);

    // including date + random to add a bit of data to sign (empty map_array would be boring right ?)
    return $token;
}
