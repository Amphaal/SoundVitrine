<?php

include_once "back/helpers/htmlHelpers.php";

function getQueryString() {
    $request_uri = explode('/', strtolower($_SERVER['REQUEST_URI']));
    $request_uri = array_filter($request_uri, 'strlen' );
    array_shift($request_uri); //remove root app 
    return $request_uri;
}

function sanitizePOST() {
    if(array_key_exists('username', $_POST)) $_POST['username'] = trim(strtolower($_POST['username']));
} 

function errorOccured($error_text) {
    if(isset($_POST['headless'])) http_response_code(520);
    exit($error_text); 
    //throw new Exception($error_text);
}

function mayCreateUserDirectory($directory) {
    $shouldWrite = !file_exists($directory);
    if (!$shouldWrite) return null;

    $result = mkdir($directory, 0777, true);
    if (!$result) 
    {
        errorOccured(i18n("e_wdu", $directory));
    }
}

function checkUserSpecificFolders() {
    //for each user
    foreach(getAllAppUsers() as $user => $confData) {
        $path = getInternalUserFolder($user);
        mayCreateUserDirectory($path);
    }
}  

function checkUserExists($user, $non_fatal_check = false) {
    $do_exist = getUserConfig($user) != null && file_exists(getInternalUserFolder($user));
    if(!$do_exist && !$non_fatal_check) errorOccured(i18n("e_unsu", $user));
    return $do_exist;
}

function comparePasswords($user) {
    $passwd = isset($_POST['password']) ? $_POST['password'] : NULL;
    if(empty($passwd)) errorOccured(i18n("e_nopass"));
    if($passwd != getUserConfig($user)["password"]) errorOccured(i18n("e_pmm"));
}

function testUploadedFile($expectedFilename){
    $fileToUpload = isset($_FILES[$expectedFilename]) ? $_FILES[$expectedFilename] : NULL;
    if(empty($fileToUpload)) errorOccured(i18n("e_upLibMiss"));
    if($fileToUpload['error'] == 4 ) errorOccured(i18n("e_noFUp"));
    if($fileToUpload['error'] > 0 ) errorOccured(i18n("e_upErr"));
}

function uploadFile($pathTo, $expectedFilename) {
        $uploadResult = move_uploaded_file($_FILES[$expectedFilename]['tmp_name'], $pathTo);
        if(!$uploadResult) errorOccured(i18n("e_upErr"));
}

function testFileCompatibility($expectedFilename) {
    $fileContent = file_get_contents($_FILES[$expectedFilename]['tmp_name']);
    
    //check if JSON compliant
    $result = json_decode($fileContent);
    if (json_last_error() !== JSON_ERROR_NONE) errorOccured(i18n("e_ucJSON"));
}

function isUselessUpload($targetPath, $expectedFilename) {
    //check for duplicate in current / uploaded file
    if (!file_exists($targetPath)) return false;
    $hash_uploaded = hash_file('sha1',$_FILES[$expectedFilename]['tmp_name']);
    $hash_current = hash_file('sha1', $targetPath);
    return $hash_uploaded == $hash_current ? true : false;
}

//
//conectivity
//

function getCurrentUserLogged() {
    return empty($_SESSION["loggedAs"]) ? "" : $_SESSION["loggedAs"];
}

function isUserLogged() {
    return !empty(getCurrentUserLogged());
}

function goToLocation($rq) {
    header('Location: ' . getLocation($rq, param));
}

function getLocation($rq) {
    $r = getRootApp();

    switch($rq) {
        case "Home":
            $r .= 'manage';
            break;
        case "ThisLibrary":
            $r .= (getQueryString()[0] ?? "");
            break;
        case "MyLibrary":
            $r .= getCurrentUserLogged();
            break;
    }

    return strtolower($r);
}

function isXMLHttpRequest(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}