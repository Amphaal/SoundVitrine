<?php

function routerInterceptor_MusicLibrary($qs_user)
{

    $expectedLibrary = getInternalUserFolder($qs_user) . constant("MUSIC_LIB_PROFILE_FILE_NAME");
    $profilePicture = getProfilePicture($qs_user);

    $expectedProfilePic = null;
    if ($profilePicture) {
        $expectedProfilePic = getPublicUserFolderOf($qs_user) . $profilePicture;
    }

    $clientURLUnified = getPublicUserFolderOf($qs_user) . constant("COMPILED_MUSIC_LIB_PROFILE_FILE_NAME");
    $clientURLShout = getPublicUserFolderOf($qs_user) . constant("SHOUT_PROFILE_FILE_NAME");

    //Client variables
    $latestUpdate = filemtime($expectedLibrary);
    $isLogged = isUserLogged();

    //addons
    setTitle(i18n('libraryOf', $qs_user));
    $initialRLoaderUrl = getLocation("Home", true);

    include "layout/explorer/entrypoint.php";
    exit;
}
