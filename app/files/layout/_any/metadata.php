<?php

$app_description = __("app_descr");
$app_icon_href = "/public/images/ico.png";
$app_title = getTitle();

function getCurrentUrl(): string
{
    // Detect scheme (with proxy headers if behind Traefik/Nginx/…)
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    } elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }

    // Host (prefer X-Forwarded-Host if provided by Traefik)
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    } else {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
    }

    // Port (optional, only if non-standard)
    $port = $_SERVER['SERVER_PORT'] ?? null;
    $showPort = $port && !in_array([$scheme, $port], [['http', '80'], ['https', '443']]);

    // Path + query
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    return $scheme . '://' . $host . ($showPort ? ':' . $port : '') . $uri;
}

?>

<meta charset="UTF-8">
<title><?=$app_title ?></title>
<link rel="icon" type="image/png" href="<?=$app_icon_href ?>" />
<meta name="description" content="<?=$app_description ?>">
<meta name="theme-color" content="#efefef">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta property="og:url" content="<?= htmlspecialchars(getCurrentUrl()) ?>">
<meta property="og:title" content="<?=$app_title ?>">
<meta property="og:description" content="<?=$app_description ?>">
<meta property="og:image" content="<?=$app_icon_href ?>">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="256">
<meta property="og:image:height" content="256">
<meta property="og:type" content="website">
<meta name="twitter:image" content="<?=$app_icon_href ?>">
<meta name="twitter:description" content="<?=$app_description ?>">
<meta name="twitter:title" content="<?=$app_title ?>">
<meta name="twitter:card" content="photo">