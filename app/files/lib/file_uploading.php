<?php

/**
 * generic cleaning of POST fields, if any
 */
function sanitizePOST()
{
    if (array_key_exists('username', $_POST)) {
        $_POST['username'] = trim(strtolower($_POST['username']));
    }
}

function getFileUploadLimit()
{
    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    return min($max_upload, $max_post, $memory_limit) * 1000;
}

function isUselessUpload($targetPath, $expectedFilename)
{
    //check for duplicate in current / uploaded file
    if (!file_exists($targetPath)) {
        return false;
    }
    $hash_uploaded = hash_file('sha1', $_FILES[$expectedFilename]['tmp_name']);
    $hash_current = hash_file('sha1', $targetPath);
    return $hash_uploaded == $hash_current ? true : false;
}

function testUploadedFile($expectedFilename)
{
    $fileToUpload = isset($_FILES[$expectedFilename]) ? $_FILES[$expectedFilename] : null;
    if (empty($fileToUpload)) {
        errorOccured(__("e_upLibMiss"));
    }
    if ($fileToUpload['error'] == 4) {
        errorOccured(__("e_noFUp"));
    }
    if ($fileToUpload['error'] > 0) {
        errorOccured(__("e_upErr"));
    }
}

function uploadFile($pathTo, $expectedFilename)
{
    $uploadResult = move_uploaded_file($_FILES[$expectedFilename]['tmp_name'], $pathTo);
    if (!$uploadResult) {
        errorOccured(__("e_upErr"));
    }
}

function prepareAndTestUploadedFileCompliance($expectedFilename)
{
    $decompressed = '';

    // check if compressed
    if ($_FILES[$expectedFilename]['type'] == "application/compressed-mlib") {
        //
        $decompressed = zlib_decode(file_get_contents($_FILES[$expectedFilename]["tmp_name"]));

        //
        file_put_contents($_FILES[$expectedFilename]["tmp_name"], $decompressed);

        //
        $_FILES[$expectedFilename]["name"] = pathinfo($_FILES[$expectedFilename]["name"], PATHINFO_FILENAME) . ".json";
        $_FILES[$expectedFilename]["full_path"] = pathinfo($_FILES[$expectedFilename]["name"], PATHINFO_FILENAME) . ".json";
        $_FILES[$expectedFilename]["type"] = "application/json";
        $_FILES[$expectedFilename]["size"] = strlen($decompressed);
    }

    //
    if (empty($decompressed)) {
        $decompressed = file_get_contents($_FILES[$expectedFilename]['tmp_name']);
    }

    //check if JSON compliant
    json_decode($decompressed);
    if (json_last_error() !== JSON_ERROR_NONE) {
        errorOccured(__("e_ucJSON"));
    }
}
