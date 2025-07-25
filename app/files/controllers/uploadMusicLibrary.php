<?php

function uploadMusicLibrary($qs_user)
{
    checkPOSTedUserPassword($qs_user);
    testUploadedFile(constant("MUSIC_LIB_UPLOAD_FILE_NAME"));
    prepareAndTestUploadedFileCompliance(constant("MUSIC_LIB_UPLOAD_FILE_NAME"));
    processUploadedMusicLibrary($qs_user, constant("MUSIC_LIB_UPLOAD_FILE_NAME"));
}

function processUploadedMusicLibrary($qs_user, $expectedFilename)
{

    $pathTo = getInternalUserFolder($qs_user) . constant("MUSIC_LIB_PROFILE_FILE_NAME");

    //check for duplicates
    if (isUselessUpload($pathTo, $expectedFilename)) {
        exit(__("fiNu"));
    }

    //archive current file if necessary
    //archivePreviousUpload($qs_user, $pathTo);

    //move the uploaded file to user's directory
    uploadFile($pathTo, $expectedFilename);

    //generate data from upload
    $dg = new DataGenerator($qs_user);
    $dg->generateUnifiedFile();

    //specific redirect for headless client
    if (isset($_POST['headless'])) {
        exit('Bon appétit!');
    }

    //redirect to users library...
    header("Location: " . dirname($_SERVER['REQUEST_URI']));
    exit();
}

function archivePreviousUpload($qs_user, $pathTo)
{
    //ignore if current file doesnt exist
    if (!file_exists($pathTo)) {
        return;
    }

    //copy save
    $archive_dir = filemtime($pathTo) . '_' . rand(0, 999);
    $copyDestination = getInternalUserFolder($qs_user) . $archive_dir . "/" . basename($pathTo);

    //archive...
    if (!mkdir(dirname($copyDestination))) {
        errorOccured(__("e_cad"));
    }
    if (!copy($pathTo, $copyDestination)) {
        errorOccured(__("e_cufad"));
    }
}

///
/// UI specifics
///

function routerMiddleware_UploadMusicLibrary($qs_user, $wantsExplicitAccess)
{
    // if having POST && FILES, means we try to upload
    if (!empty($_POST) && !empty($_FILES)) {
        return uploadMusicLibrary($qs_user);
    }

    /**
 * check if calling from COMPANION_APP
*/
    $isAPICall = isset($_POST['headless']);

    /**
 * if called from API, always expect POST and FILES to be filled
*/
    if ($isAPICall) {
        errorOccured(__("missingArgs"));
    }

    // redirect to upload UI if no library for the user OR wanting explicitely this UI
    $expectedLibrary = getInternalUserFolder($qs_user) . constant("MUSIC_LIB_PROFILE_FILE_NAME");
    if (!file_exists($expectedLibrary) || $wantsExplicitAccess) {
        setTitle(__("title_uploadMusicLibrary"));
        return injectAndDisplayIntoAdminLayout("layout/admin/components/upload.php", get_defined_vars());
    }
}
