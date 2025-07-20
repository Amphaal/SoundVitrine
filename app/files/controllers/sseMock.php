<?php

use Ahc\Jwt\JWT;

function routerInterceptor_sseMocking($qs_action)
{
    switch ($qs_action) {
        case 'send': {
            if (empty($_POST)) {
                http_response_code(404);
                break;
            }

            $toUser = $_POST["toUser"];
            if (empty($toUser)) {
                http_response_code(500);
                echo "Missing target user";
            }

            // Instantiate with key, algo, maxAge and leeway.
            $jwt = new JWT(getenv("MERCURE_PUBLISHER_JWT_KEY"), 'HS256');
            $token = $jwt->encode([
                "mercure" => [
                    "publish" => ["*"],
                ]
            ]);

            $data = http_build_query([
                'topic' => sprintf(SHOUT_URI_TEMPLATE, $toUser),
                'data' => json_encode([
                    "album" => "The Black Album",
                    "artist" => "Metallica",
                ])
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
            if ($result === false) {
                /* Handle error */
            }

            echo "OK";
        }
        break;

        default: {
            include "layout/mock/entrypoint.php";
            exit;
        }
    }
}
