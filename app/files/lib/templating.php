<?php

/**
 * does an echo of each files contained in $path_to_dir folder (not recursive)
 */
function echoFilesOfFolder($path_to_dir)
{
    foreach (getFilesInFolder($path_to_dir) as $file) {
        echo file_get_contents($file);
    }
    echo("\n");
}

/**
 * list alls files within a folder (not recursive)
 */
function getFilesInFolder($path_to)
{
    // get files, dirs and ., ..
    $maybeFiles = scandir($path_to);

    // removes ., ..
    $maybeFiles = array_diff($maybeFiles, ['..', '.']);
    $files = [];

    foreach ($maybeFiles as $maybeFile) {
        $maybeFileFullPath = $path_to . '/' . $maybeFile;
        if (!is_file($maybeFileFullPath)) {
            continue;
        }
        array_push($files, $maybeFileFullPath);
    }

    //
    return $files;
}

/** */
function injectAndDisplayIntoAdminLayout($inside_part, $included_vars_array)
{

    foreach ($included_vars_array as $varname => $value) {
        $$varname = $value;
    }

    unset($included_vars_array);
    unset($varname);
    unset($value);

    if (isXMLHttpRequest()) {
        include $inside_part;
    } else {
        include "layout/admin/entrypoint.php";
    }

    //
    exit;
}
