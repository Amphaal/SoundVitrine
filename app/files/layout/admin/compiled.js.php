<script>
    const i18n = <?=json_encode(I18nSingleton::getInstance()->getDictionary()) ?>;
    const lang = <?=json_encode(I18nSingleton::getInstance()->getLang()) ?>;
    <?php echoFilesOfFolder("layout/admin/js") ?>
</script>