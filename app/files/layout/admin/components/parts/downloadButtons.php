<div>
    <a target="_blank" href="<?=constant("COMPANION_APP_GITHUB_LATEST_RELEASE_URL") ?>">
        <div class='companionAppDownloadExplain'>
            <span>
                <span><?=__("obtainCompanionApp_1") ?></span>
                <span class='obtain'><?=constant("COMPANION_APP_NAME") ?></span>
            </span>
            <span><?=__("obtainCompanionApp_2") ?></span>
        </div>
    </a>
    <div id="dlContainer">
        <?php foreach ($dd_folders as $folder) {?>
            <?php /* TODO */ ?>
            <a class="<?=$folder?>" href="/download/<?=$folder?>" title="<?=__("downloadFeeder", fromDownloadFolderToOS($folder)) ?>"></a>
        <?php }?>
    </div>
</div>