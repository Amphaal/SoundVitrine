<?php

function routerInterceptor_heartbeat($qs_action)
{
    switch ($qs_action) {
        case 'creds': {
            if (empty($_POST)) {
                http_response_code(400);
                exit;
            }

            // require extra undocumented custom header to limit naive brute forcing
            $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
            $clientVersion = $_SERVER['HTTP_X_CLIENT_VERSION'];
            if (!isset($clientId) || !isset($clientVersion) || $clientId != COMPANION_APP_NAME) {
                http_response_code(400); // Bad request
                exit;
            }

            // check credentials
            $errMsg = checkCredentials($_POST['username'], $_POST['password']);
            if ($errMsg != null) {
                http_response_code(403); // Forbidden
                echo $errMsg;
                exit;
            }

            // else, OK !
            echo "OK";
            exit;
        }
        break;
    }
}
