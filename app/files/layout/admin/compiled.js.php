<script>
    const i18n = <?php echo json_encode(I18nSingleton::getInstance()->getDictionary()) ?>;
    const lang = <?php echo json_encode(I18nSingleton::getInstance()->getLang()) ?>;
    <?php echoFilesOfFolder("layout/admin/js") ?>
</script>