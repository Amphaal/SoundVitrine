<div>
    <a target="_blank" href="<?php echo constant("COMPANION_APP_GITHUB_LATEST_RELEASE_URL") ?>"><div class='companionAppDownloadExplain'>
            <span>
                <span><?php echo i18n("obtainCompanionApp_1")?></span>
                <span class='obtain'><?php echo constant("COMPANION_APP_NAME") ?></span>
            </span>
            <span><?php echo i18n("obtainCompanionApp_2")?></span>
        </div>
    </a>
    <div id="dlContainer">
        <?php foreach ($dd_folders as $folder) {?>
            <?php /* TODO */ ?>
            <a class="<?php echo $folder?>" href="/download/<?php echo $folder?>" title="<?php echo i18n("downloadFeeder", fromDownloadFolderToOS($folder))?>"></a>
        <?php }?>
    </div>
</div>