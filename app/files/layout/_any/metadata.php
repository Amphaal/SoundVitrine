<?php

$app_description = __("app_descr");
$app_og_background_href = "/public/favicon/web-app-manifest-512x512.png";
$app_title = getTitle();

function getCurrentCanonicalUrl(): string
{
    // Detect scheme (with proxy headers if behind Traefik/Nginx/…)
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    } elseif (getenv('ENFORCE_CANONICAL_HTTP_SCHEME') == '1') {
        $scheme = 'http';
    } else {
        // let's assume HTTPS as canonical scheme by default
        $scheme = 'https';
    }

    // Host (prefer X-Forwarded-Host if provided by Traefik)
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    } else {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
    }

    // Path + query
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    return $scheme . '://' . $host . $uri;
}

?>

<meta charset="UTF-8">
<title><?=$app_title ?></title>
<link rel="icon" type="image/png" href="/public/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="shortcut icon" href="/public/favicon/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png" />
<link rel="manifest" href="/public/favicon/site.webmanifest" />
<meta name="description" content="<?=$app_description ?>">
<meta name="theme-color" content="#efefef">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta property="og:url" content="<?= htmlspecialchars(getCurrentCanonicalUrl()) ?>">
<meta property="og:title" content="<?=$app_title ?>">
<meta property="og:description" content="<?=$app_description ?>">
<meta property="og:image" content="<?=$app_og_background_href ?>">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="256">
<meta property="og:image:height" content="256">
<meta property="og:type" content="website">
<meta name="twitter:image" content="<?=$app_og_background_href ?>">
<meta name="twitter:description" content="<?=$app_description ?>">
<meta name="twitter:title" content="<?=$app_title ?>">
<meta name="twitter:card" content="photo">