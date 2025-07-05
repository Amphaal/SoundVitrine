<!DOCTYPE html>
<html lang="<?php echo I18nSingleton::getInstance()->getLang() ?>">
    <head>
        <?php require "layout/_any/metadata.php" ?>

        <?php

              /**
               * 1a. external JS libs
               */

        ?>
        <?php require "layout/admin/compiled.js-ext.php" ?>
        <script type="text/javascript" src="/public/ext/js/highcharts.js"></script>
        <script type="text/javascript" src="/public/ext/js/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="/public/ext/js/sorttable.js"></script>
        <script type="text/javascript" src="/public/ext/js/hammer.min.js"></script>
        <script type="text/javascript" src="/public/ext/js/mixitup.min.js"></script>
        <?php /**
               * 1b. internal JS libs + PHP-to-JS variables
               */ ?>
        <?php require "layout/explorer/js/vars.php" ?>
        <?php require "layout/admin/compiled.js.php" ?>
        <script>
            <?php
                echoFilesOfFolder("public/ext/js/polyfills");
                echoFilesOfFolder("layout/explorer/js/misc");
                echoFilesOfFolder("layout/explorer/js/app");
                echoFilesOfFolder("layout/explorer/js/app/panels");
            ?>
        </script>

        <?php /**
               * 2aa All-purposes CSS
               */ ?>
        <?php require "layout/admin/compiled.css.php"; ?>
        <style>
            <?php echoFilesOfFolder("layout/explorer/css"); ?>
        </style>
        <?php /**
               * 2b. Profile specific CSS
               */ ?>
        <style>
            <?php echo cbacToCss($qs_user, UserDb::fromProtected($qs_user)["customColors"]) ?>
        </style>
    </head>
    <body>
        <?php require "layout/explorer/components/loader.php" ?>
        <?php require "layout/explorer/components/music_library/parts/shoutWidget.php" ?>
        <main id="main-app">
            <?php require "layout/explorer/components/music_library/music_library.php" ?>
            <?php require "layout/explorer/components/account.php" ?>
        </main>
        <?php require "layout/explorer/components/bg.php" ?>
    </body>
</html>
