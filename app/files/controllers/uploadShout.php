<?php

function uploadShout($qs_user)
{
    // preliminary tests
    checkPOSTedUserPassword($qs_user);
    testUploadedFile(constant("SHOUT_UPLOAD_FILE_NAME"));
    prepareAndTestUploadedFileCompliance(constant("SHOUT_UPLOAD_FILE_NAME"));

    // uploading file
    $whereToUpload = getInternalUserFolder($qs_user) . constant("SHOUT_PROFILE_FILE_NAME");
    uploadFile($whereToUpload, constant("SHOUT_UPLOAD_FILE_NAME"));

    //
    exit(__("shouted"));
}

function routerInterceptor_uploadShout($qs_user)
{
    //
    $isAPICall = isset($_POST['headless']);
    if (!$isAPICall) {
        http_response_code(500);
        die('expects API call');
    }

    //check prerequisites
    if (!empty($_POST) && !empty($_FILES)) {
        return uploadShout($qs_user);
    } else {
        errorOccured(__("missingArgs"));
    }
}
