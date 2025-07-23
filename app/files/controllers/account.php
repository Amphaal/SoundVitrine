<?php

require "lib/data-generator/data_generator.php";

function routerInterceptor_Account($qs_action)
{
    switch ($qs_action) {
        case "create":
            return accountCreation();
        case "disconnect":
            return disconnect();
        case "pp":
            return ProfilePic();
        case "bb":
            return BackgroundBand();
        default:
            return home();
    }
}

function BackgroundBand()
{
    $newColors = file_get_contents('php://input');
    if (!$newColors) {
        return;
    }
    $newColors = json_decode($newColors);

    if (!isUserLogged()) {
        return;
    }

    UserDb::update(["customColors" => $newColors]);
    echo "OK";
    return;
}


function ProfilePic()
{
    //upload
    if ($_FILES && isUserLogged()) {
        //prepare...
        $currentUser = getCurrentUserLogged();
        $expectedFilename = "file";
        $ext = pathinfo($_FILES[$expectedFilename]['name'], PATHINFO_EXTENSION);
        testUploadedFile($expectedFilename);

        //upload...
        $ppname = getProfilePicFilename($ext);
        $internalDest = getInternalUserFolder($currentUser) . $ppname;
        uploadFile($internalDest, $expectedFilename);

        //remove previous if different ext...
        $currentpicFN = getProfilePicture($currentUser);
        if ($currentpicFN && $currentpicFN != $ppname) {
            $currentpicFN = getInternalUserFolder($currentUser) . $currentpicFN;
            @unlink($currentpicFN);
        }

        //update DB
        setMyProfilePicture($ppname);

        //return
        ob_clean();
        flush();
        echo getPublicUserFolderOf($currentUser) . $ppname;
        return;
    }
}

function home()
{

    $login_result = null;
    login($login_result);

    //prepare
    $iul = isUserLogged();
    $mylib_loc = getLocation("MyLibrary");
    $is_not_my_lib = true;
    $dd_folders = [];

    //if user is logged...
    if ($iul) {
        $is_not_my_lib = (getLocation("ThisLibrary") != $mylib_loc);

        //downloads...
        $curUser = getCurrentUserLogged();
        $pp = getProfilePicture($curUser);
        $pp_path = null;
        if ($pp) {
            $pp_path = getPublicUserFolderOf($curUser) . $pp;
        }
    }

    //title
    $title = $iul ? "e_log_manage" : "e_log_home";
    setTitle(__($title));

    injectAndDisplayIntoAdminLayout("layout/admin/components/home.php", get_defined_vars());
}



function accountCreation()
{
    $rules = [
        "username" => ["min" => 6, "max" => 20],
        "password" => ["min" => 8, "max" => 20],
    ];

    $acr = null;
    if ($_POST) {
        $acr = tryCreatingUser($rules);
        if (!$acr["isError"]) {
            login();
        }
    }

    injectAndDisplayIntoAdminLayout("layout/admin/components/create_account.php", get_defined_vars());
}

function disconnect()
{
    session_unset();
    session_destroy();

    if (isXMLHttpRequest()) {
        goToLocation("Home");
    } else {
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}

function login(&$login_result = null)
{
    //
    if (!$_POST) {
        return;
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    //
    $login_result = connectAs($username, $password);
    $has_failed = $login_result['isError'];
    if ($has_failed) {
        return;
    }

    //
    if (isXMLHttpRequest()) {
        goToLocation("Home");
    } else {
        goToLocation("MyLibrary");
    }
}

function tryCreatingUser($rules)
{

    $ret = ["description" => null];

    $user = $_POST['username'];
    $passwd = $_POST['password'];
    $end_checks = false;

    //checks...
    while (!$end_checks && empty($ret["description"])) {
        //fields filed
        foreach ($rules as $field => $f_rules) {
            if (empty($field)) {
                $ret["description"] = __("crea_miss_p_u", __($field));
                continue;
            }
        }

        // is user already logged
        if (isUserLogged()) {
            $ret["description"] = __("err_nocreate_onlog");
            continue;
        }

        //check user asked to create exists
        if (checkUserExists($user, true)) {
            $ret["description"] = __("user_already_exist", $user);
            continue;
        }

        //check username over regex
        $isUNOk = null;
        preg_match('/^[a-zA-Z0-9]+([_-]?[a-zA-Z0-9])*$/', $user, $isUNOk);
        if (count($isUNOk) == 0) {
            $ret["description"] = __("username_invalid", $user);
            continue;
        }

        //check if min/max length on fields
        foreach ($rules as $field => $f_rules) {
            $len = strlen($_POST[$field]);
            $min = $f_rules['min'];
            $max = $f_rules['max'];

            if ($len < $min || $len > $max) {
                $ret["description"] = __(
                    "field_nc_pattern",
                    __($field),
                    $min,
                    $max
                );
                continue;
            }
        }

        //checks OK
        $end_checks = true;
    }

    //check if return
    $ret["isError"] = !empty($ret["description"]);
    if ($ret["isError"]) {
        return $ret;
    }

    //else create account
    UserDb::update(
        [
            "password" => $passwd,
            "email" => $_POST['email'],
            "customColors" => randomizeBannerColors()
        ],
        $user
    );

    return $ret;
}

function randomizeBannerColors()
{
    $getRandColorHex = function () {
        $getRandColorGroup = function () {
            return str_pad(strtoupper(dechex(rand(0, 255))), 2, "0", STR_PAD_LEFT);
        };
        return "#" . $getRandColorGroup() . $getRandColorGroup() . $getRandColorGroup();
    };
    return [$getRandColorHex(), $getRandColorHex(), $getRandColorHex(), $getRandColorHex()];
}

/**
 * @return error_message error message if failed
 */
function checkCredentials($username, $passwd): ?string
{
    if (empty($username)) {
        return __("e_log_nouser");
    }

    if (empty($passwd)) {
        return __("e_nopass");
    }

    $user_data = UserDb::from($username);
    if ($user_data == null) {
        return __("e_unsu", $username);
    }

    if ($passwd != $user_data["password"]) {
        return __("e_pmm");
    }

    return null;
}

function connectAs($username, $passwd)
{
    // shape expected for response
    $ret = [
        "isError" => false,
        "description" => null, // string
    ];

    // check if already logged as username
    if (isset($_SESSION["loggedAs"]) && $_SESSION["loggedAs"] == $username) {
        $ret["description"] = __("e_log_identical");
        return $ret;
    }

    // checking if current credentials throws an error message
    $err = checkCredentials($username, $passwd);
    if ($err != null) {
        $ret["isError"] = true;
        $ret["description"] = $err;
        return $ret;
    }

    // persist login
    $_SESSION["loggedAs"] = $username;

    //
    return $ret;
}
