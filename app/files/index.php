<?php

// display errors on http response
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//
set_include_path(__DIR__);
require 'vendor/autoload.php';

include "config.php";

// handles users sessions, start
session_start();

include "lib/i18n.php";
include "lib/users-management/users_management.php";
include "lib/web_title.php";
include "lib/web_user-agent.php";
include "lib/css_compiler.php";
include "lib/string_extensions.php";
include "lib/error_handling.php";
include "lib/templating.php";
include "lib/templating.shards.php";
include "lib/file_uploading.php";
include "lib/http.php";
include "lib/magnifik_input.php";

include "controllers/uploadMusicLibrary.php";
include "controllers/uploadShout.php";
include "controllers/manage.php";
include "controllers/downloadApp.php";
include "controllers/musicLibrary.php";

function init_app()
{
    //
    checkUserSpecificFolders(); // generate folders if non existing
    sanitizePOST(); // cleanup POST

    // get URI elements
    $qs = getQueryString();

    // 1st part of URL
    $qs_domain = array_shift($qs);

    //
    switch ($qs_domain) {
        // should be handled by proxy (database files)
        // case 'data' : {}

        // should be handled by proxy (WebServices)
        // case 'sentry': {}

        case 'manage': {
            $qs_action = array_shift($qs); // 2nd part of URL
            return routerInterceptor_Manage($qs_action);
        }
        break;

        case 'download': {
            $qs_action = array_shift($qs); // 2nd part of URL
            return routerInterceptor_Download($qs_action);
        }
        break;

        case 'u': {
            // 2cnd part of URL
            $qs_user =  array_shift($qs);
            if (!empty($qs_user)) {
                $qs_user = strtolower($qs_user); // always lower
            }

            //
            checkUserExists($qs_user);

            // 3rd part of URL
            $qs_action = array_shift($qs);

            //
            switch ($qs_action) {
                case 'uploadShout': {
                    return routerInterceptor_uploadShout($qs_user);
                }
                break;

                case 'uploadMusicLibrary':
                default: {
                    // if user has no library
                    routerMiddleware_UploadMusicLibrary($qs_user, $qs_action == 'uploadMusicLibrary');

                    // if action provided, but unknown, redirect to admin home
                    if (!empty($qs_action)) {
                        home();
                    } else {
                        // else, show music library
                        routerInterceptor_MusicLibrary($qs_user);
                    }
                }
            }
        }
        break;

        // means root "/"
        case null: {
            // get users so we can display them
            $users = UserDb::all();
            setTitle(i18n("welcome"));
            injectAndDisplayIntoAdminLayout("layout/admin/components/welcome.php", get_defined_vars());
        }

        default: {
            /** */
        }
        break;
    }

    // will default to 404 not found
    http_response_code(404);
}

init_app();
