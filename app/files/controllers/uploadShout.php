<?php

function uploadShout($qs_user)
{
    // preliminary tests
    checkPOSTedUserPassword($qs_user);

    $fileName = constant("SHOUT_UPLOAD_FILE_NAME");
    testUploadedFile($fileName);
    prepareAndTestUploadedFileCompliance($fileName);

    // send SSE event
    $jsonContent = file_get_contents($_FILES[$fileName]['tmp_name']);
    sendSSEEvent_shout($qs_user, json_decode($jsonContent));

    // uploading file
    $whereToUpload = getInternalUserFolder($qs_user) . constant("SHOUT_PROFILE_FILE_NAME");
    uploadFile($whereToUpload, $fileName);

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
