<?php

/**
 * Configuration and constants
 */

/** */
define("APP_NAME", "SoundVitrine");

/** */
define("CREATOR_EMAIL", "guillaume.vara@gmail.com");

/** */
define("COMPANION_APP_NAME", "SoundBuddy");

/**
 * when COMPANION_APP_NAME does a library upload, expect the library to be named as
*/
define("MUSIC_LIB_UPLOAD_FILE_NAME", constant("APP_NAME") . "_file");

/**
 * when COMPANION_APP_NAME does a shout, expect this as filename
*/
define("SHOUT_UPLOAD_FILE_NAME", "shout_file");

/** */
define("MUSIC_LIB_PROFILE_FILE_NAME", 'current.json');

/** */
define("COMPILED_MUSIC_LIB_PROFILE_FILE_NAME", 'unified.json');

/** */
define("SHOUT_PROFILE_FILE_NAME", 'shout.json');

/**
 * where - on the current domain the app is installed - is exposed the root of the app
*/
define("WEB_APP_ROOT", "/");

/** */
define("WEB_APP_ROOT_FULLPATH", ($_SERVER["REQUEST_SCHEME"] ?: 'http') . "://" . $_SERVER["HTTP_HOST"] . constant("WEB_APP_ROOT"));

/**
 * use WSS in production environment
*/
define("SHOUT_SERVICE_WEBSOCKET_ROOT_HOST", $_SERVER["HTTP_HOST"] . "/sentry");

/**
 * since theses colors can be customized by user
*/
define("DEFAULT_BACKGROUND_COLORS", ["#EE7752", "#E73C7E", "#23A6D5", "#23D5AB"]);

/**
 * where to store state files on filesystem
*/
define("STATE_FOLDER_PATH", getenv("SOUNDVITRINE_STATE_PATH") ?: "/app/_state");

/**
 * internal folder path of user's data
*/
define("USER_DB_FILE_PATH", constant("STATE_FOLDER_PATH") . "/users.json");

/** */
define("COMPANION_APP_GITHUB_LATEST_RELEASE_URL", "https://github.com/Amphaal/SoundBuddy/releases/latest");

/** */
define("ALLOW_SSE_TESTING", (bool)getenv("ALLOW_SSE_TESTING"));
define("MERCURE_PATH", "/.well-known/mercure");
define("MERCURE_LOCAL_URL", "http://localhost" . MERCURE_PATH);

// printf template; first "%s" is userToSubscribeTo
define("SHOUT_URI_TEMPLATE", "com.amphaal.soundvitrine/shouts/user/%s");

//
//
//

/** */
function getProfilePicFilename($ext)
{
    return "pp." . $ext;
}

/**
 * internal folder path of user's data
 */
function getInternalUserFolder($user)
{
    return constant("STATE_FOLDER_PATH") . "/users/" . $user . "/";
}

/**
 * web server exposed user's data
 */
function getPublicUserFolder()
{
    return constant("WEB_APP_ROOT") . "data/users/";
}


/**
 * web server exposed user's data
 */
function getPublicUserFolderOf($user)
{
    return getPublicUserFolder() . $user . "/";
}
