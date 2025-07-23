<!DOCTYPE html>
<html lang="<?=I18nSingleton::getInstance()->getLang() ?>">
    <head>
        <?php require "layout/_any/metadata.php" ?>
        <?php require "layout/admin/compiled.js-ext.php" ?>
        <?php require "layout/admin/compiled.css.php" ?>
        <?php require "layout/admin/compiled.js.php" ?>
    </head>
    <body>
        <div id="mainFrame">
            <?php require $inside_part; ?>
        </div>
        <?php require "layout/_any/footer.php" ?>
    </body>
</html>