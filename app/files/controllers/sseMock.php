<?php

function routerInterceptor_sseMocking($qs_action)
{
    switch ($qs_action) {
        case 'send': {
            if (empty($_POST)) {
                http_response_code(404);
                exit;
            }

            //
            $toUser = $_POST["toUser"];
            if (empty($toUser)) {
                http_response_code(400);
                echo "Missing target user";
                exit;
            }

            //
            $test_payload = [
                    "album" => "The Black Album",
                    "artist" => "Metallica",
            ];

            // send payload with topic
            $result = sendSSEEvent_shout(
                $toUser,
                $test_payload,
            );

            // handle result
            if ($result === false) {
                http_response_code(500);
                echo "Failed sending event";
                exit;
            }

            //
            echo "OK";
        }
        break;

        default: {
            $sub_token = getSSESubscriberJWT();
            include "layout/mock/entrypoint.php";
            exit;
        }
    }
}
